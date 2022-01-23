@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            $(document).ready( function () {
                toastr.error("{{ $error }}");
            });
        </script>
    @endforeach
@endif
@if (session('error'))
    <script>
        $(document).ready( function () {
            toastr.warning("{{ session('error') }}");
        });
    </script>
@endif
@if (session('status'))
    <script>
        $(document).ready( function () {
            toastr.success("{{ session('status') }}");
        });
    </script>
@endif
