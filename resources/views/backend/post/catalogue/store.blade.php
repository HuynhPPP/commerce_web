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
    $url = ($config['method'] == 'create') ? route('post.catalogue.store') : route('post.catalogue.update', $postCatalogue->id);
@endphp
<form action="{{ $url }}" method="POST" class="box">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-9">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Thông tin chung</h5>
                    </div>
                    <div class="ibox-content">
                        @include('backend.post.catalogue.component.general')
                    </div>
                </div>
                @include('backend.post.catalogue.component.seo')
            </div>

            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Chọn danh mục cha
                                    <span class="text-danger">(*)</span></label>
                                    <span class="text-danger notice">*Chọn Root nếu không có danh mục cha</span></label>
                                    <select
                                        class="form-control setupSelect2"
                                        name="" 
                                        id=""
                                    >
                                        <option value="0">Chọn danh mục cha</option>
                                        <option value="1">Root</option>
                                        <option value="2">Bóng đá</option>
                                    </select>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Chọn ảnh đại diện</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <div class="image img-cover">
                                        <img src="backend/img/no-image.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
        <hr>
       
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
