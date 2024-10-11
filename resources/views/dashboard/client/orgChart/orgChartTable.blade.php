<div class="table-responsive">
    <table id="Departments-data" class="table table-hover table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
               @foreach ($orgchart as $column)
                   <th>{{$column->user_label}}</th>
               @endforeach
                <th>{{__('Company')}}</th>
                <th>{{__('Sector')}}</th>
                <th>{{__('Level')}}</th>
                <th>{{__('HR Department?')}}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>
