<ul class="tree">
    @foreach ($subDepartments as $department)
         <li oncontextmenu="ShowRespondents('{{ $department->id }}')">
            @if($department->subDepartments->count()>0)

        <details>
            <summary><span class="m-1 p-1 bg-success"> {{ $department->name_en }} <i class="fa fa-user-plus"></i>
                <sub class="text-wihte" style="font-size: 0.6rem;">{{ __('Right Click To Add') }}</sub>
            </span></summary>
            @include('dashboard.client.orgChart.subDepartments',['subDepartments'=>$department->subDepartments])
        </details>
        @else
        <span class="m-1 p-1 bg-success"> {{ $department->name_en }} <i class="fa fa-user-plus"></i></span>
        @endif
        <p>
            <a href="javascript:void(0)"  onclick="ShowAdd('{{ $client->id }}','{{ $department->id }}','sub-dep')" class="btn btn-sm btn-info m-2">{{ __('Add Sub-Department') }}</a>
        </p>
    </li>
    @endforeach
    {{-- <li><a href="javascript:void(0)"  onclick="ShowAdd('{{ $client->id }}','{{ $department->id }}','sub-dep')" class="btn btn-sm btn-info">{{ __('Add Sub-Department') }}</a></li> --}}
</ul>
