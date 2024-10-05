<div class="card mt-4" style="letter-spacing: 0.065rem;">
    <div class="card-header">
        <h3 class="card-title">{{ $type == 'sec' ? __('Companies') : __('Sectors') }}</h3>
    </div>
    <div class="card-body text-capitalize">
        <div class="table-responsice">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ $type == 'sec' ? __('Company') : __('Sector') }}</th>
                        <th>{{ __('View Result') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($heatmap as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $type == 'sec' ? $item['name'] : $item['name'] }}
                        </td>
                        <td>
                            <a href="{{ route('clients.SurveyResults', [$client_id, $service_type, $id, $item['type'], $item['id']]) }}"
                                class="btn btn-success" target="_blank">{{ __('View') }}</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
