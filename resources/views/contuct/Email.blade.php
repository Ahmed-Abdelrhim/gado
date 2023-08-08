@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h5 class="m-0" style="display: inline;">النشرة البريدية</h5>
               
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th> البريد </th>
                  <th>التاريخ</th>
              
                </tr>
                </thead>
                <tbody>
                @foreach($Email as $key => $value)
                    <tr>
                      <td>{{$key+1}}</td>
 
                      <td>{{$value->email}}</td>
                      <td> <span class="badge badge-success">{{Date::parse($value->created_at)->diffForHumans()}}</span></td>
                     
                    </tr>
                @endforeach
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
        {{--warning--}}
       
       
       


    </div>
@endsection

@section('script')
<script type="text/javascript">
    // add section

</script>
@endsection

