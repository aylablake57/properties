<x-app-layout>
    <x-slot name="header">
        <h1>{{ __('Prices') }}</h1>
    </x-slot>

    <div class="my-3">
        <div class="row">
            <div class="col-sm-12">
            <div class="tab-content">
            
            @if (session('import_errors'))
                <div class="alert alert-danger">
                @foreach (session('import_errors') as $error)
                Row#{{ $error['row'] . ": " . $error['errors'][0] }} <br>
                @endforeach
                </div>
            @endif

            <form action="{{ route('price.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="section-title">Import File</div>
                <div class="section-content">
                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <label for="title">Select File <span class="text-danger fs-12">*(Mandatory)</span></label>
                            <input type="file" class="form-control" name="import_file" required>
                            @error('import_file')
                                <span class='text-danger fs-12'>{{ $message }}</span>
                            @enderror
                            <button class="btn btn-accent">Import</button>
                        </div>
                    </div>
                </div>
            </form>
            <table class="table table-bordered">
            <thead>
                <tr>
                <th>City</th>
                <th>Phase</th>
                <th>Sector</th>
                <th>125 YDS</th>
                <th>133 YDS</th>
                <th>200 YDS</th>
                <th>250 YDS</th>
                <th>300 YDS</th>
                <th>400 YDS</th>
                <th>500 YDS</th>
                <th>800 YDS</th>
                <th>1000 YDS</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($prices as $price)
                <tr>
                <th scope="row">{{ $price->city }}</th>
                <td>{{ $price->phase }}</td>
                <td>{{ $price->sector }}</td>
                <td>{{ $price['125_yards'] }}</td>
                <td>{{ $price['133_yards'] }}</td>
                <td>{{ $price['200_yards'] }}</td>
                <td>{{ $price['250_yards'] }}</td>
                <td>{{ $price['300_yards'] }}</td>
                <td>{{ $price['400_yards'] }}</td>
                <td>{{ $price['500_yards'] }}</td>
                <td>{{ $price['800_yards'] }}</td>
                <td>{{ $price['1000_yards'] }}</td>
                </tr>
            @endforeach
            </tbody>
            </table>
            </div>
            </div>
        </div>
    </div>
</x-app-layout>