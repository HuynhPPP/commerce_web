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

<form action="{{ route('post.catalogue.destroy', $postCatalogue->id) }}" method="POST" class="box">
    @csrf
   
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">{{ __('messages.generalTitle')}}</div>
                    <div class="panel-description">
                        <p>{{ __('messages.generalDescription')}} <span class="text-danger">{{$postCatalogue->name}}</span></p>
                        <p><span class="text-danger">{{ __('messages.deleteWarning')}} </span>{{ __('messages.generalDescription2')}}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">{{ __('messages.postCatalogue.table.title')}}
                                    <span class="text-danger">(*)</span></label>
                                    <input 
                                        type="text"
                                        name="name"
                                        value="{{ old('name', ($postCatalogue->name) ?? '' ) }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                        readonly
                                    >
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-right">
            <button 
                class="btn btn-danger"
                type="submit"
                name="send"
                value="send"
            >
            {{ __('messages.deleteButton')}}
            </button>
        </div>
    </div>
</form>
