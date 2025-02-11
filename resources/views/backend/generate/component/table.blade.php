<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th style="width: 50px">
            <input type="checkbox" id="checkAll" value="checkAll" class="input-checkbox">
        </th>
        <th>Tên module</th>
        <th class="text-center">Thao tác</th>
    </tr>
    </thead>
    <tbody>
    @if(isset($generates) && is_object($generates))
    @foreach($generates as $generate)
    <tr>
        <td>
            <input type="checkbox" value="{{ $generate->id }}" class="input-checkbox checkBoxItem">
        </td>
        
        <td>
            {{$generate->name}}
        </td>

        <td class="text-center">
            <a href="{{ route('language.edit', $generate->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
            <a href="{{ route('language.delete', $generate->id) }}" 
            class="btn btn-danger"><i class="fa fa-trash"></i></a>
        </td>
    </tr>
    @endforeach
    @endif
    </tbody>
</table>
{{$generates->links('pagination::bootstrap-4')}}


