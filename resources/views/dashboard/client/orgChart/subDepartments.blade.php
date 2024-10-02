<ul class="tree m-1">
    @foreach ($subDepartments as $department)
        <li oncontextmenu="ShowRespondents('{{ $department->id }}')" class="m-1">
            @if ($department->subDepartments->count() > 0)
                <details>
                    <summary><span class="m-1 p-1 bg-success">
                            {{ 'c-' . $department->dep_level . ' ' . $department->name_en }} <i
                                class="fa fa-user-plus"></i>
                            <sub class="text-wihte" style="font-size: 0.6rem;">{{ __('Right Click To Add') }}</sub>
                        </span></summary>
                    @include('dashboard.client.orgChart.subDepartments', [
                        'subDepartments' => $department->subDepartments,
                    ])
                </details>
            @else
                <span class="m-1 p-1 bg-success"> {{ 'c-' . $department->dep_level . ' ' . $department->name_en }} <i
                        class="fa fa-user-plus"></i></span>
            @endif
            {{-- <p>
                @if (($client->use_departments && $department->dep_level < 4) || ($client->use_sections && $department->dep_level < 5))
                    <a href="javascript:void(0)"
                        onclick="ShowAdd('{{ $client->id }}','{{ $department->id }}','sub-dep')"
                        class="btn btn-sm btn-info m-2">{{ __('Add Sub-Department') . __(' To: ') . $department->name_en }}</a>
                @endif
            </p> --}}
        </li>
        @if ($client->use_departments && $department->dep_level < 4 || $client->use_sections && $department->dep_level < 5)
            <li><a href="javascript:void(0)" onclick="ShowAdd('{{ $client->id }}','{{ $department->id }}','sub-dep')"
                    class="btn btn-sm btn-info m-1">{{ __('Add Sub-Department') . __(' To: ') . $department->name_en }}</a>
            </li>
        @endif
    @endforeach
    {{-- <li><a href="javascript:void(0)"  onclick="ShowAdd('{{ $client->id }}','{{ $department->id }}','sub-dep')" class="btn btn-sm btn-info">{{ __('Add Sub-Department') }}</a></li> --}}
</ul>
