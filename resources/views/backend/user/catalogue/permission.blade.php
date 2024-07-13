@include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['table']['title']])

<form action="" method="POST" class="box">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Cáp quyền</h5>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th></th>
                                @foreach($userCatalogues as $userCatalogue)
                                <th class="text-center">{{$userCatalogue->name}}</th>
                                @endforeach
                            </tr>
                            @foreach($permissions as $permission)
                            <tr>
                                <td><a href="">{{$permission->name}}</a></td>
                                @foreach($userCatalogues as $userCatalogue)
                                <td>
                                    <input type="checkbox" name="permission[]" value=""
                                    class="form-control">
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </table>
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