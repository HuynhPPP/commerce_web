<div class="row mb15">
    <div class="col-lg-12">
        <div class="form-row">
            <label for="" class="control-label text-left">Tiêu đề nhóm bài viết
            <span class="text-danger">(*)</span></label>
            <input 
                type="text"
                name="name"
                value="{{ old('name', ($postCatalogue->name) ?? '' ) }}"
                class="form-control"
                placeholder=""
                autocomplete="off"
            >
        </div>
    </div>
</div>
<div class="row mb15">
    <div class="col-lg-12">
        <div class="form-row">
            <label for="" class="control-label text-left mb15">Mô tả ngắn
            <textarea 
                type="text"
                name="description"
                id="ckDescription"
                class="form-control ck-editor mt15"
                placeholder=""
                autocomplete="off"
                data-height="150"
            >{{ old('description', ($postCatalogue->description) ?? '' ) }}</textarea>
            
              
        </div>
    </div>
</div>
<div class="row mb15">
    <div class="col-lg-12">
        <div class="form-row">
            <label for="" class="control-label text-left mb15">Nội dung
            <textarea 
                type="text"
                name="content"
                id="ckContent"
                class="form-control ck-editor"
                placeholder=""
                autocomplete="off"
                data-height="500"
            >{{ old('content', ($postCatalogue->content) ?? '' ) }}</textarea> 
            
             
        </div>
    </div>
</div>