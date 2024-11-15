<?php

namespace App\Http\Controllers\reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\centros\Centrocosto;
use App\Models\SaleDetail;
use App\Models\Compensadores_detail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\ComprasXProdExport;



class reportecomprarequeridaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dateFrom = session('dateFrom');
        $dateTo = Carbon::parse($request->input('dateTo'))->format('Y-m-d');
       /*  $dateTo = session('dateTo'); */

        /*  $dateFrom = '2024-05-01';
         */

        $category = Category::orderBy('name', 'asc')->get();
        $centros = Centrocosto::Where('status', 1)->get();

        return view('reportes.compras_requeridas', compact('category', 'centros', 'dateFrom', 'dateTo'));
    }


    public function show(Request $request)
    {
        $dateFrom = $request->input('dateFrom');
        $dateTo = $request->input('dateTo');
        // Guardar los valores en la sesión
        session(['dateFrom' => $dateFrom, 'dateTo' => $dateTo]);

        $data = DB::select("
        SELECT 
        products.code as product_code,
        products.name as product_name,
        categories.name as category_name,
                    orders.id AS pedido,
                orders.fecha_order,
                SUM(order_details.quantity) AS total_cant,
                centro_costo_products.stock
            FROM
                zjgifbmb_carnicossv.orders
                    JOIN
                zjgifbmb_carnicossv.order_details ON orders.id = order_details.order_id
                    JOIN
                zjgifbmb_carnicossv.products ON order_details.product_id = products.id
                    JOIN
                zjgifbmb_carnicossv.categories ON products.category_id = categories.id
                    JOIN
                zjgifbmb_carnicossv.centro_costo_products ON products.id = centro_costo_products.products_id
            WHERE
                orders.fecha_order BETWEEN '$dateFrom' AND '$dateTo'
                    AND orders.status = '1'
            GROUP BY products.id
        ");

        return datatables()->of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function reporteExcel($dateFrom, $dateTo)
    {
        /*   $dateFrom = '2024-05-20'; */
        // $dateTo = Carbon::parse($request->input('dateTo'))->format('Y-m-d');
        $dateFrom = $dateFrom;
        $dateTo = $dateTo;


        /*   $dateFrom = $request->input('dateFrom');
        $dateTo = $request->input('dateTo');
 */
        // dd($dateFrom, $dateTo);

        $reportName = 'Reporte compras por productos_' . uniqid() . '.xlsx';
        return Excel::download(new ComprasXProdExport($dateFrom, $dateTo), $reportName);
    }

    public function showEloquent(Request $request)
    {
        /* $dateFrom = $request->input('dateFrom');
        $dateTo = $request->input('dateTo'); */

        /*   $dateFrom = Carbon::now()->format('Y-m-d H:i:s');
        $dateTo = Carbon::now()->format('Y-m-d H:i:s');

          /*   $from = $request->input('dateFrom');
        $to = $request->input('dateTo');

         $from = '2024-04-01';
        $to = '2024-05-16';        

         $from = Carbon::parse($request->input('startDate'))->format('Y-m-d');
        $to = Carbon::parse($request->input('endDate'))->format('Y-m-d');
/*
 */
        $dateFrom = '2024-05-08 01:00:01';
        $dateTo = '2024-05-08 21:20:01';

        $data = Product::with(['compensadores_details', 'category', 'despostere', 'despostecerdo', 'despostepollo'])
            ->leftjoin('compensadores_details', 'products.id', '=', 'compensadores_details.products_id')
            ->leftjoin('desposteres', 'products.id', '=', 'desposteres.products_id')
            ->leftjoin('despostecerdos', 'products.id', '=', 'despostecerdos.products_id')
            ->leftjoin('despostepollos', 'products.id', '=', 'despostepollos.products_id')
            ->whereHas('compensadores_details', function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('created_at', ['2024-05-08 00:00', '2024-05-08 22:00'])
                    ->where('status', '1');
            })
            ->select(
                'products.code as product_code',
                'products.name as product_name',
                'categories.name as category_name',
                DB::raw('SUM(COALESCE(desposteres.peso, 0) + COALESCE(despostecerdos.peso, 0) + COALESCE(despostepollos.peso, 0)) as cant_compras_lote'),
                DB::raw('SUM(COALESCE(desposteres.costo, 0) + COALESCE(despostecerdos.costo, 0) + COALESCE(despostepollos.costo, 0)) as costo_compras_lote'),
                DB::raw('SUM(compensadores_details.peso) as cant_compras_comp'),
                DB::raw('SUM(compensadores_details.pcompra) as precio_compras_comp'),
                DB::raw('SUM(compensadores_details.subtotal) subtotal_compras_comp')
            )
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->groupBy('products.id', 'products.name', 'categories.name')
            ->orderBy('products.name', 'ASC')
            ->get();

        // dd($data);

        return datatables()->of($data)
            ->addIndexColumn()
            ->make(true);
    }


    public function totales(Request $request)
    {
        $centrocostoId = $request->input('centrocostoId');
        $categoriaId = $request->input('categoriaId');

        $data = DB::table('centro_costo_products as ccp')
            ->join('products as pro', 'pro.id', '=', 'ccp.products_id')
            ->join('categories as cat', 'pro.category_id', '=', 'cat.id')
            ->select(
                'cat.name as namecategoria',
                'pro.name as nameproducto',
                'ccp.invinicial as invinicial',
                'ccp.compralote as compraLote',
                'ccp.alistamiento',
                'ccp.compensados as compensados',
                'ccp.trasladoing as trasladoing',
                'ccp.trasladosal as trasladosal',
                'ccp.venta as venta',
                'ccp.notacredito as notacredito',
                'ccp.notadebito as notadebito',
                'ccp.venta_real as venta_real',
                'ccp.stock as stock',
                'ccp.fisico as fisico'
            )
            ->where('ccp.centrocosto_id', $centrocostoId)
            ->where(function ($query) {
                $query->where('ccp.tipoinventario', 'cerrado')
                    ->orWhere('ccp.tipoinventario', 'inicial');
            })
            ->where('pro.category_id', $categoriaId)
            ->where('pro.status', 1)
            ->get();

        $totalStock = 0;
        $totalInvInicial = 0;
        $totalCompraLote = 0;
        $totalAlistamiento = 0;
        $totalCompensados = 0;
        $totalTrasladoIng = 0;
        $totalVenta = 0;
        $totalTrasladoSal = 0;
        $totalIngresos = 0;
        $totalSalidas = 0;
        $totalConteoFisico = 0;

        $diferenciaKilos = 0;
        $porcMermaPermitida = 0;
        $difKilosPermitidos = 0;
        $difKilos = 0;
        $porcMerma = 0;
        $difPorcentajeMerma = 0;

        foreach ($data as $item) {

            $stock = ($item->invinicial + $item->compraLote + $item->alistamiento + $item->compensados + $item->trasladoing) - ($item->venta_real + $item->trasladosal);
            $item->stock = round($stock, 2);
            $totalStock += $stock;

            $ingresos = ($item->invinicial + $item->compraLote + $item->alistamiento + $item->compensados + $item->trasladoing);
            $item->ingresos = round($ingresos, 2);
            $totalIngresos += $ingresos;

            $ventas = ($item->venta - $item->notacredito) + $item->notadebito;
            $item->ventas = round($ventas, 2);

            $salidas =  $item->trasladosal + (($item->venta - $item->notacredito) + $item->notadebito);
            $item->salidas = round($salidas, 2);
            $totalSalidas += $salidas;

            $totalInvInicial += $item->invinicial;
            $totalCompraLote += $item->compraLote;
            $totalAlistamiento += $item->alistamiento;
            $totalCompensados += $item->compensados;
            $totalTrasladoIng += $item->trasladoing;
            $totalVenta += $item->ventas;
            $totalTrasladoSal += $item->trasladosal;

            $totalConteoFisico += $item->fisico;
            $diferenciaKilos = $totalConteoFisico - $totalStock;
        }

        if ($totalIngresos <= 0) {
            $totalIngresos = 1;
        }

        $porcMerma = $diferenciaKilos / $totalIngresos;

        $porcMermaPermitida = 0.005;
        $difKilosPermitidos = -1 * ($totalIngresos * $porcMermaPermitida);
        $difKilos = $diferenciaKilos - $difKilosPermitidos;


        $difPorcentajeMerma = $porcMerma + $porcMermaPermitida;

        return response()->json(
            [
                'totalStock' => number_format($totalStock, 2),

                'totalInvInicial' => number_format($totalInvInicial, 2),
                'totalCompraLote' => number_format($totalCompraLote, 2),
                'totalAlistamiento' => number_format($totalAlistamiento, 2),
                'totalCompensados' => number_format($totalCompensados, 2),
                'totalTrasladoing' => number_format($totalTrasladoIng, 2),

                'totalVenta' => number_format($totalVenta, 2),
                'totalTrasladoSal' => number_format($totalTrasladoSal, 2),

                'totalIngresos' => number_format($totalIngresos, 2),
                'totalSalidas' => number_format($totalSalidas, 2),

                'totalConteoFisico' => number_format($totalConteoFisico, 2),

                'diferenciaKilos' => number_format($diferenciaKilos, 2),
                'difKilosPermitidos' => number_format($difKilosPermitidos, 2),
                'porcMerma' => number_format($porcMerma * 100, 2),
                'porcMermaPermitida' => number_format($porcMermaPermitida * 100, 2),
                'difKilos' => number_format($difKilos, 2),
                'difPorcentajeMerma' => number_format($difPorcentajeMerma * 100, 2),

            ]
        );
    }
   
}
