<div class="ibox">
    <div class="ibox-title">
        <h5>{{ __('messages.parent_id')}}</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-row">
                  
                    <span class="text-danger notice">{{ __('messages.parent_notice')}}</span></label>
                    <select class="form-control setupSelect2" name="parent_id" id="">
                        @foreach($dropdown as $key => $val)
                        <option 
                            {{ $key == old('parent_id', (isset($postCatalogue->parent_id)) ? 
                                    $postCatalogue->parent_id : '') ? 'selected' : '' }}
                            value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>  
    </div>
</div>
<div class="ibox">
    <div class="ibox-title">
        <h5>{{ __('messages.image')}}</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-row">
                    <span class="image img-cover image-target">
                        <img src="{{ (old('image', ($postCatalogue->image) ?? '') ? old('image', ($postCatalogue->image) ?? '') : 'backend/img/no_image.png') }}" alt="">
                    </span>
                    <input 
                        type="hidden" 
                        name="image" 
                        value="{{ old('image', ($postCatalogue->image) ?? '' ) }}"
                    >
                </div>
            </div>
        </div>  
    </div>
</div>
<div class="ibox">
    <div class="ibox-title">
        <h5>{{ __('messages.config_advange')}}</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-row">
                    <div class="mb15">
                        <select
                        class="form-control setupSelect2"
                        name="publish" 
                        id=""
                    >
                    @foreach(config('apps.general.publish') as $key => $val)
                        <option 
                            {{ $key == old('publish', (isset($postCatalogue->publish)) ? 
                                $postCatalogue->publish : '') ? 'selected' : '' }}
                            value="{{ $key }}">{{ $val }}
                        </option>
                    @endforeach
                    </select>
                    </div>
                    <select
                        class="form-control setupSelect2"
                        name="follow" 
                        id=""
                    >
                    @foreach(config('apps.general.follow') as $key => $val)
                        <option 
                            {{ $key == old('follow', (isset($postCatalogue->follow)) ? 
                                $postCatalogue->follow : '') ? 'selected' : '' }}
                            value="{{ $key }}">{{ $val }}
                        </option>
                    @endforeach
                    </select>
                </div>
            </div>
        </div>  
    </div>
</div>
