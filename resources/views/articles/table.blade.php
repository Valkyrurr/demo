<table class="table table-bordered table-dark table-responsive" id="articles">
    <thead>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Content</th>
        </tr>
    </thead>
</table>

@section('pagespecificscripts')
<script>
    $('#articles').DataTable({
        serverSide: true,
        processing: true,
        responsive: true,
        ajax: "{{ route('articles.table') }}",
        columns: [
            { name: 'id' },
            { name: 'title' },
            { name: 'content' },
        ],
    });
</script>
@endsection
