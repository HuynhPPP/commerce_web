<div class="ibox">
    <div class="ibox-title">
        <h5>{{ __('messages.parent_id')}}</h5>
    </div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                  
                    <span class="text-danger notice">{{ __('messages.parent_notice')}}</span></label>
                    <select class="form-control setupSelect2" name="post_catalogue_id" id="">
                        @foreach($dropdown as $key => $val)
                        <option 
                            {{ $key == old('post_catalogue_id', (isset($post->post_catalogue_id)) ? 
                                    $post->post_catalogue_id : '') ? 'selected' : '' }}
                            value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>  

        @php
            $catalogue = [];
            if(isset($post)){
                foreach($post->post_catalogues as $key => $val){
                    $catalogue[] = $val->id;
                }
            }
        @endphp

        <div class="row">
            <div class="col-lg-12">
                <div class="form-row">
                    <label class="control-label">{{ __('messages.children_id')}}</label>
                    <select multiple class="form-control setupSelect2" name="catalogue[]" id="">
                        @foreach($dropdown as $key => $val)
                        <option
                            @if(is_array(old('catalogue', (
                                isset($catalogue) && count($catalogue)) ? $catalogue : [])
                                ) && isset($post->post_catalogue_id) && $key !== $post->post_catalogue_id && in_array($key, 
                                old('catalogue', (isset($catalogue)) ? $catalogue : []))
                            )
                            selected
                            @endif value="{{ $key }}">{{ $val }}</option>
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
                        <img src="{{ (old('image', ($post->image) ?? '') ? old('image', ($post->image) ?? '') : 'backend/img/no_image.png') }}" alt="">
                    </span>
                    <input 
                        type="hidden" 
                        name="image" 
                        value="{{ old('image', ($post->image) ?? '' ) }}"
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
                    @foreach(__('messages.publish') as $key => $val)
                        <option 
                            {{ $key == old('publish', (isset($post->publish)) ? 
                                $post->publish : '') ? 'selected' : '' }}
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
                    @foreach(__('messages.follow') as $key => $val)
                        <option 
                            {{ $key == old('follow', (isset($post->follow)) ? 
                                $post->follow : '') ? 'selected' : '' }}
                            value="{{ $key }}">{{ $val }}
                        </option>
                    @endforeach
                    </select>
                </div>
            </div>
        </div>  
    </div>
</div>
