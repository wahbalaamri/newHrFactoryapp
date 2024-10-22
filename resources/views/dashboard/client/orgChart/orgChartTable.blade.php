<div class="table-responsive">
    <table id="Departments-data" class="table table-hover table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>{{__('Sector')}}</th>
                <th>{{__('Company')}}</th>
               @foreach ($orgchart as $column)
                   <th>{{$column->user_label}}</th>
               @endforeach

                <th>{{__('Level')}}</th>
                <th>{{__('HR Department?')}}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
