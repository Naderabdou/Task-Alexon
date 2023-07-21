@extends('dashboard.layout.master')
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Striped Table</h4>
                <button type="button" class="btn btn-sm btn-primary"data-target="#editMezalta" data-toggle="modal">Add Category</button>


                <div class="modal fade" id="editMezalta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabel">New message</h4>
                            </div>
                            <form action="{{route('category.store')}}" method="post" enctype="multipart/form-data">

                            <div class="modal-body">
                                    @csrf
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">name_Ar:</label>
                                        <input type="text" class="form-control" id="recipient-name" name="name_ar">
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label">name_En:</label>
                                        <input type="text" class="form-control" id="recipient-name" name="name_en">
                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="control-label">Image:</label>
                                        <input type="file" class="form-control" id="recipient-name" name="image">
                                    </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-primary" value="create">
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <table class="table table-striped"style="margin-top: 12px">
                    <thead>
                    <tr>
                        <th> ID </th>
                        <th> Name AR </th>
                        <th> Name EN </th>
                        <th> image </th>
                        <th> Action </th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                    $i=1
                    @endphp
                    @foreach($categories as $category)
                    <tr>

                        <td> {{$i++}} </td>

                        <td> {{$category->name_ar}} </td>
                        <td> {{$category->name_en}} </td>

                        <td class="py-1">
                            <img src="{{$category->image}}" alt="image" />
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info"data-target="#edit_{{$category->id}}" data-toggle="modal">edit</button>
                            <button type="button" class="btn btn-sm btn-danger"data-target="#delete_{{$category->id}}" data-toggle="modal">delete</button>




                        </td>

                    </tr>


                    <!-- Button trigger modal -->

                    <div class="modal fade" id="edit_{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="exampleModalLabel">edit category</h4>
                                </div>
                                <form action="{{route('category.update',$category->id)}}" enctype="multipart/form-data" method="post">

                                <div class="modal-body">
                                        @csrf
                                        @method('put')
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">name AR:</label>
                                            <input type="text" class="form-control" id="recipient-name" name="name_ar" value="{{$category->name_ar}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">name En:</label>
                                            <input type="text" class="form-control" id="recipient-name" name="name_en"  value="{{$category->name_en}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="control-label">Image:</label>
                                            <input type="file" class="form-control" id="recipient-name" name="image">
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">update</button>
                                </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="delete_{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="exampleModalLabel">New message</h4>
                                </div>
                                <form method="post" action="{{route('category.destroy',$category->id)}}">

                                <div class="modal-body">
                                        @csrf
                                        @method('delete')
                                        <div class="form-group">

                                            <p>are you sure delete</p>

                                        </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">delete</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
