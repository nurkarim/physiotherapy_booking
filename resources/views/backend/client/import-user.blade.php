@extends('backend.index')
@section('content')
    <style type="text/css">
        table th{font-weight: 400;font-size: 14px;letter-spacing: 1px;}
        table tr td{font-weight: 400;font-size: 13px;letter-spacing: 1px;color: black}
        #dataTables-example_length{display: none;}
    </style>
    <link href="{{url('public')}}/css/app.css" rel="stylesheet">

    <div class="row">
        <div class="col-md-12">
            <h4 style="font-weight: 400;">Clients</h4>
        </div>
        <div class="col-md-12">
            <h2>Client import</h2>
        </div>
        <div class="col-md-12">
            <form action="{{route('bulk-import-user')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="file" name="file" id="file">

                <button>import</button>
            </form>
        </div>
    </div>

    <script type="text/javascript">

    </script>
@endsection
