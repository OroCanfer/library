@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-fex justify-content-between">
                            <div>Books list </div>
                            <div>
                                <a class="btn btn-success" href="{{route('books.create')}}">Create book</i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p></p>
                            </div>
                        @endif

                        <div class="mb-2">
                            <form class="form-inline" action="">
                                <div class="col-md-6">
                                    <label for="categoryFilter">Filter by category</label>
                                    <select class="form-control" id="categoryFilter" name="category" onchange="search_book()">
                                        <option value="">Select category</option>
                                        @foreach ($categories as $category)
                                            <option value="{!! $category->name !!}" {{(Request::query('category') && Request::query('category') == $category->name) ? 'selected': ''}}>{!! $category->name !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="search">&nbsp;&nbsp;</label>
                                    <input type="text" value="{{(Request::query('search')) ? Request::query('search') : ''}}" name="search" class="form-control" placeholder="Search..." id="search">
                                    <span>&nbsp;</span>
                                    <button type="button" onclick="search_book()" class="btn btn-primary">Search</button>
                                    @if(Request::query('category') || Request::query('search'))
                                        <a href="{{route('books.index')}}" class="btn btn-success">Clear</a>
                                    @endif
                                </div>
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-stripped table-responsive-lg">
                                <tr>
                                    <th>Name</th>
                                    <th>Author
                                        @if(Request::query('sortByAuthor') && Request::query('sortByAuthor') == 'asc')
                                            <a href="javascript:sortByAuthor('desc')"><i class="fas fa-sort-down"></i></a>
                                        @elseif(Request::query('sortByAuthor') && Request::query('sortByAuthor') == 'desc')
                                            <a href="javascript:sortByAuthor('asc')"><i class="fas fa-sort-up"></i></a>
                                        @else
                                            <a href="javascript:sortByAuthor('asc')"><i class="fas fa-sort"></i></a>
                                        @endif
                                    </th>
                                    <th>Category
                                        @if(Request::query('sortByCategory') && Request::query('sortByCategory') == 'asc')
                                            <a href="javascript:sortByCategory('desc')"><i class="fas fa-sort-down"></i></a>
                                        @elseif(Request::query('sortByCategory') && Request::query('sortByCategory') == 'desc')
                                            <a href="javascript:sortByCategory('asc')"><i class="fas fa-sort-up"></i></a>
                                        @else
                                            <a href="javascript:sortByCategory('asc')"><i class="fas fa-sort"></i></a>
                                        @endif
                                    </th>
                                    <th>Publish date</th>
                                    <th>Is borrowed</th>
                                    <th>Borrowed by</th>
                                    <th>Actions</th>
                                </tr>
                                @if (count($books))
                                    @foreach ($books as $book)
                                        <tr>
                                            <td>{!! $book->name !!}</td>
                                            <td>{!! $book->author !!}</td>
                                            <td>{!! $book->category->name !!}</td>
                                            <td>{!! $book->publishDate !!}</td>
                                            @if ($book->userId != NULL && $book->userId != 0) 
                                                <td>borrowed 
                                            @else
                                                <td>available 
                                            @endif
                                                    <a id="availabilityButton" data-toggle="modal" data-target="#availabilityModal" title="edit availability" data-book="{!! $book->id !!}" data-user="{!! $book->userId !!}">
                                                        <i class="fas fa-edit  fa-lg"></i>
                                                    </a>
                                                </td>
                                            @if ($book->user)
                                                <td>{!! $book->user->name !!}</td>
                                            @else
                                                <td>none</td>
                                            @endif
                                            <td>
                                                <a class="btn btn-success" href="{{route('books.show', $book->id)}}">Detail</a>

                                                <a class="btn btn-primary" href="{{route('books.edit', $book->id)}}" data-attr="{!! $book->id !!}">Edit</a>
                                                <a class="btn btn-danger" id="deleteButton" data-toggle="modal" data-target="#deleteModal" data-book="{!! $book->id !!}">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">No books found.</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $books->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- availability update modal -->
    <div class="modal fade" id="availabilityModal" tabindex="-1" role="dialog" aria-labelledby="availabilityModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="availabilityBody">
                    <div>
                        <form action="" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Borrowed by:</strong>
                                        <select name="userId" class="form-control">
                                            <option value="0">Select a user</option>
                                            @foreach ($users as $user)
                                                <option value="{!! $user->id !!}">{!! $user->name !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>  
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- delete confirmation modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="deleteBody">
                    <div>
                        <form action="" method="POST">

                            @csrf
                            @method('DELETE')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Delete the book?</strong>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">

    var query = <?php echo json_encode((object)Request::query()); ?>;

    function search_book(){

        Object.assign(query, {'category': $('#categoryFilter').val()});
        Object.assign(query, {'search': $('#search').val()});

        window.location.href = "{{route('books.index')}}?" + $.param(query);
    }

    function sortByAuthor(value){
        Object.assign(query, {'sortByAuthor': value});

        window.location.href = "{{route('books.index')}}?" + $.param(query);
    }

    function sortByCategory(value){
        Object.assign(query, {'sortByCategory': value});

        window.location.href = "{{route('books.index')}}?" + $.param(query);
    }

    // display availability modal
    $(document).on('click', '#availabilityButton', function(event) {
        event.preventDefault();

        let book = $(this).attr('data-book');
        let user = $(this).attr('data-user');

        let href = '/books/' + book + '/availability';

        $('#availabilityModal form').attr('action', href);
        if(user != '' && user != null)
            $('#availabilityModal select').val(user);

        $('#availabilityModal').modal("show");

    });

    //display delete model
    $(document).on('click', '#deleteButton', function(event) {
        event.preventDefault();
        let book = $(this).attr('data-book');

        let href = '/books/' + book;

        $('#deleteModal form').attr('action', href);

        $('#deleteModal').modal("show");

    });
</script>

@endsection