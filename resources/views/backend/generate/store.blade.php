@include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['create']['title']])

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@php
    $url = ($config['method'] == 'create') ? route('generate.store') : route('generate.update', $generate->id);
@endphp
<form action="{{ $url }}" method="POST" class="box">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin chung</div>
                    <div class="panel-description">
                        <p>Nhập thông tin chung của Module</p>
                        <p>Lưu ý: Những trường đánh dấu <span class="text-danger">(*)</span> là bắt buộc</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Tên Module
                                    <span class="text-danger">(*)</span></label>
                                    <input 
                                        type="text"
                                        name="name"
                                        value="{{ old('name', ($generate->name) ?? '' ) }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Loại Module
                                    <span class="text-danger">(*)</span></label>
                                    <select name="module_type" id="" class="form-control setupSelect2">
                                        <option value="0">Chọn loại Module</option>
                                        <option value="1">Module danh mục</option>
                                        <option value="2">Module chi tiết</option>
                                        <option value="2">Module khác</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông Schema</div>
                    <div class="panel-description">
                        <p>Nhập thông tin Schema</p>
                        <p>Lưu ý: Những trường đánh dấu <span class="text-danger">(*)</span> là bắt buộc</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Schema
                                    <span class="text-danger">(*)</span></label>
                                    <textarea 
                                        name="schema"
                                        value="{{ old('schema', ($generate->schema) ?? '' ) }}"
                                        class="form-control schema"
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="text-right">
            <button 
                class="btn btn-primary"
                type="submit"
                name="send"
                value="send"
            >
            Lưu lại
            </button>
        </div>
    </div>
</form>
