<div class="row mb15">
    <div class="col-lg-12">
        <div class="form-row">
            <label for="" class="control-label text-left">{{ __('messages.title')}}
            <span class="text-danger">(*)</span></label>
            <input 
                type="text"
                name="name"
                value="{{ old('name', ($post->name) ?? '' ) }}"
                class="form-control"
                placeholder=""
                autocomplete="off"
            >
        </div>
    </div>
</div>
<div class="row mb30">
    <div class="col-lg-12">
        <div class="form-row">
            <label for="" class="control-label text-left mb15">{{ __('messages.description')}}
            <textarea 
                type="text"
                name="description"
                id="ckDescription"
                class="form-control ck-editor mt15"
                placeholder=""
                autocomplete="off"
                data-height="150"
            >{{ old('description', ($post->description) ?? '' ) }}</textarea>
            
              
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="form-row">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <label for="" class="control-label text-left mb15">{{ __('messages.content')}} </label>
                <a href="" class="multipleUploadImageCkeditor" data-target="ckContent">{{ __('messages.multiple_image')}}</a>
            </div>
            
            <textarea 
                type="text"
                name="content"
                id="ckContent"
                class="form-control ck-editor"
                placeholder=""
                autocomplete="off"
                data-height="500"
            >{{ old('content', ($post->content) ?? '' ) }}</textarea> 
            
             
        </div>
    </div>
</div>