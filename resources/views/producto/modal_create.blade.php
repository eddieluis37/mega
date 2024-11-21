<div class="row">
    <div class="col-sm-12">
        <div class="connect-sorting-content">
            <div class="card simple-title-task ui-sortable-handle">
                <div class="card-body">
                    <div class="btn-toolbar justify-content-between">
                        <div>
                            <input type="hidden" value="0" name="idbeneficio" id="idbeneficio">
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="task-header">
                                <div class="form-group">
                                    <label>Categoria</label>
                                    <div>
                                        <select class="form-control form-control-sm" name="centrocosto_id" id="centrocosto_id" required="">
                                            <option value="">Seleccione la categoria</option>
                                            @foreach ($categorias as $c)
                                            <option value="{{$c->id}}" {{ $c->id == 1 ? 'selected' : '' }}>{{$c->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('centrocostoid') <span class="text-danger er">{{ $message}}</span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="task-header">
                                <div class="form-group">
                                    <label>Marca</label>
                                    <select class="form-control selectVisceras" name="clientvisceras_id" id="clientvisceras_id" required="">
                                        <option value="">Buscar un proveedor</option>
                                        @foreach ($proveedores as $p)
                                        <option value="{{$p->id}}">{{$p->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('clientviscerasid') <span class="text-danger er">{{ $message}}</span>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-3">
                            <div class="task-header">
                                <div class="form-group">
                                    <label>Nivel</label>
                                    <select class="form-control selectPieles" name="clientpieles_id" id="clientpieles_id" required="">
                                        <option value="">Buscar un nivel</option>
                                        @foreach ($niveles as $p)
                                        <option value="{{$p->id}}">{{$p->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('clientpielesid') <span class="text-danger er">{{ $message}}</span>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="task-header">
                                <div class="form-group">
                                    <label>Presentacion</label>
                                    <select class="form-control selectVisceras" name="clientvisceras_id" id="clientvisceras_id" required="">
                                        <option value="">Buscar una presentacion</option>
                                        @foreach ($presentaciones as $p)
                                        <option value="{{$p->id}}">{{$p->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('clientviscerasid') <span class="text-danger er">{{ $message}}</span>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="task-header">
                                <div class="form-group">
                                    <label>Familia</label>
                                    <select class="form-control selectProvider" name="thirds_id" id="thirds_id" required="">
                                        <option value="">Buscar una familia</option>
                                        @foreach ($familias as $p)
                                        <option value="{{$p->id}}">{{$p->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('thirdsid') <span class="text-danger er">{{ $message}}</span>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="task-header">
                                <div class="form-group">
                                    <label>Subfamilia</label>
                                    <input type="text" class="form-control" name="factura" id="factura" placeholder="ej: Chorizo" required="">
                                    @error('cantidad') <span class="text-danger er">{{ $message}}</span>@enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-12 col-md-3">
                            <div class="task-header">
                                <div class="form-group">
                                    <label>Código</label>
                                    <input type="text" class="form-control" name="finca" id="finca" placeholder="ej: RE001" required>
                                    @error('finca') <span class="text-danger er">{{ $message}}</span>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="task-header">
                                <div class="form-group">
                                    <label>Código de Barras</label>
                                    <input type="text" class="form-control" name="finca" id="finca" placeholder="ej: 777666999222333" required>
                                    @error('finca') <span class="text-danger er">{{ $message}}</span>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="task-header">
                                <div class="form-group">
                                    <label>Stock Alertas</label>
                                    <div>
                                        <select class="form-control form-control-sm" name="plantasacrificio_id" id="plantasacrificio_id" required="">
                                            <option value="">Seleccione</option>
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                        @error('plantasacrificioid') <span class="text-danger er">{{ $message}}</span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <label for="sacrificio">IVA</label>
                            <div class="input-group flex-nowrap">
                                <input type="text" name="pesopie1" id="pesopie1" class="form-control" aria-describedby="helpId" placeholder="ej: 0" step="0.01" required="">
                                <span class="input-group-text" id="addon-wrapping">%</span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <label for="fomento">Otro Impuesto</label>
                            <div class="input-group flex-nowrap">
                                <input type="text" name="pesopie1" id="pesopie1" class="form-control" aria-describedby="helpId" placeholder="ej: 0" step="0.01" required="">
                                <span class="input-group-text" id="addon-wrapping">%</span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Seleccione la imagen</label>
                                <input class="form-control" type="file" id="formFile">
                            </div>
                        </div>
                    </div>
                    <!--div class="col-sm-12 col-md-4">
									<div class="task-header">
										<div class="form-group">
											<label>Fecha</label>
											<input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" name="fecha_beneficio" id="fecha_beneficio" placeholder="ej: dd/dd/aaaa">
											@error('fecha_beneficio') <span class="text-danger er">{{ $message}}</span>@enderror
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-4">
									<div class="task-header">
										<div class="form-group">
											<label>Lote</label>
											<input type="text" class="form-control" name="lote" id="lote" placeholder="ej: PCD789" required="" readonly>
											@error('lote') <span class="text-danger er">{{ $message}}</span>@enderror
										</div>
									</div>
								</div>-->
                </div>
            </div>
        </div>
    </div>

</div>