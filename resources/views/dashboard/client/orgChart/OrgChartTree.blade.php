<div class="row justify-content-center">
    <div class="col-12">
        <ul class="tree">
            <li class="super-parent">
                <details>
                    <summary>{{ __('Client Name:') }} {{ $client->name }}</summary>
                    <ul class="tree3">
                        @foreach ($client->sectors as $sector)
                            <li class="parent">
                                <details>
                                    <summary>{{ __('Sector Name:') }} {{ $sector->name_en }}</summary>
                                    <ul class="m-1">
                                        @foreach ($sector->companies as $company)
                                            <li
                                                @if (!$client->use_departments) oncontextmenu="ShowRespondents('{{ $company->id }}')" @endif>
                                                @if ($client->use_departments && $company->departments->count() > 0)
                                                    <details>
                                                        <summary>{{ __('Company Name:') }} {{ $company->name_en }}
                                                        </summary>
                                                        <ul class="m-1">
                                                            @foreach ($company->departments->where('parent_id', null) as $department)
                                                                <li class="m-1"
                                                                    oncontextmenu="ShowRespondents('{{ $department->id }}')">
                                                                    @if ($department->subDepartments->count() > 0)
                                                                        <details>
                                                                            <summary><span class="m-1 p-1 bg-success">
                                                                                    {{ 'c-' . $department->dep_level . ' ' . $department->name_en }}
                                                                                    <i class="fa fa-user-plus"></i>
                                                                                    <sub class="text-wihte"
                                                                                        style="font-size: 0.6rem;">{{ __('Right Click To Add') }}</sub>
                                                                                </span></summary>
                                                                            @include(
                                                                                'dashboard.client.orgChart.subDepartments',
                                                                                [
                                                                                    'subDepartments' =>
                                                                                        $department->subDepartments,
                                                                                ]
                                                                            )
                                                                        </details>
                                                                    @else
                                                                        <span class="m-1 p-1 bg-success">
                                                                            {{ $department->name_en }} <i
                                                                                class="fa fa-user-plus"></i>
                                                                            <sub class="text-wihte"
                                                                                style="font-size: 0.6rem;">{{ __('Right Click To Add') }}</sub>
                                                                        </span>
                                                                    @endif
                                                                </li>
                                                                @if ($client->use_departments && $department->dep_level < 4)
                                                                <li><a href="javascript:void(0)"
                                                                        onclick="ShowAdd('{{ $client->id }}','{{ $department->id }}','sub-dep')"
                                                                        class="btn btn-sm btn-info m-1">{{ __('Add Sub-Department') . __(' To: ') . $department->name_en}}</a>
                                                                </li>
                                                            @elseif($client->use_sections && $department->dep_level < 5)
                                                                <li><a href="javascript:void(0)"
                                                                        onclick="ShowAdd('{{ $client->id }}','{{ $department->id }}','sub-dep')"
                                                                        class="btn btn-sm btn-info m-1">{{ __('Add Sub-Department') }}</a>
                                                                </li>
                                                            @endif
                                                            @endforeach

                                                        </ul>
                                                    </details>
                                                @else
                                                    {{ __('Company Name:') }} {{ $company->name_en }}
                                                @endif
                                            </li>
                                            <li>
                                                <div class="row">
                                                    @if ($client->use_departments)
                                                        <div class="col-6 m-1"><a href="javascript:void(0)"
                                                                onclick="ShowAdd('{{ $client->id }}','{{ $company->id }}','dep')"
                                                                class="btn btn-sm btn-warning">{{ __('Add Department') }}</a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                        <li>
                                            <div class="row">
                                                @if ($client->multiple_company)
                                                    <div class="col-6 m-1"><a href="javascript:void(0)"
                                                            onclick="ShowAdd('{{ $client->id }}','{{ $sector->id }}','comp')"
                                                            class="btn btn-sm btn-success">{{ __('Add Company') }}</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </li>
                                    </ul>
                                </details>
                            </li>
                        @endforeach
                        @if ($client->multiple_sectors)
                            <li>
                                <a href="javascript:void(0)"
                                    onclick="ShowAdd('{{ $client->id }}','{{ $sector->id }}','sector')"
                                    class="btn btn-sm btn-primary">{{ __('Add Sector') }}</a>
                            </li>
                        @endif
                    </ul>
                </details>
            </li>
        </ul>
    </div>
</div>
