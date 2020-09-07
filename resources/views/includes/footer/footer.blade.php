    </body>
    <script src="{{ url('js/jquery-ui.min.js') }}"></script>
    <script src="{{ url('js/bootstrap.min.js') }}"></script>
    <script src="{{ url('js/app.js') }}"></script>
    <script src="{{ url('plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ url('plugins/switchery/switchery.min.js') }}"></script>
    <!-- <script src="{{ url('plugins/tag-it/tag-it.min.js') }}"></script> -->
    <!-- <script src="{{ url('plugins/fast-click/fastclick.min.js') }}"></script> -->
    <script src="{{ url('js/scripts.js') }}"></script>
    <script src="{{ url('plugins/datatables/media/js/jquery.dataTables.js') }}"></script>
    <script src="{{ url('plugins/datatables/media/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ url('plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript">
        
        $('.js-post-action-link').on('click', (event) => {
            event.preventDefault();
            const url = $(event.currentTarget).attr('href');
            const token = $('input[name="_token"]');

            const data = {
                "_token": token[0].value,
            };

            console.log(url);

            console.log(data);

            $.ajax({
              type: "POST",
              url: url,
              data: data,
              success: (res) => {
                console.log(res);
              },
            });
        });
    </script>
</html>