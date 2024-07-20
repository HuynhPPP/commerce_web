<div class="row mb15">
    <div class="col-lg-12">
        <div class="form-row">
            <label for="" class="control-label text-left">{{ __('messages.title')}}
            <span class="text-danger">(*)</span></label>
            <input 
                type="text"
                name="translate_name"
                value="{{ old('translate_name', ($model->name) ?? '' ) }}"
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
                name="translate_description"
                id="ckDescription_1"
                class="form-control ck-editor mt15"
                placeholder=""
                autocomplete="off"
                data-height="150"
            >{{ old('translate_description', ($model->description) ?? '' ) }}</textarea>
            
              
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
                name="translate_content"
                id="ckContent_1"
                class="form-control ck-editor"
                placeholder=""
                autocomplete="off"
                data-height="500"
            >{{ old('content', ($model->content) ?? '' ) }}</textarea> 
            
             
        </div>
    </div>
</div>