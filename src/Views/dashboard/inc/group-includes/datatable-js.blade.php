<script src="{{asset('js/admin/datatable/datatable.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/persian-date@1.1.0/dist/persian-date.min.js"></script>
<script src="https://unpkg.com/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>
<script>
    function makeOption(elementId , value , text, selected = false){
        $('#'+elementId).append($('<option>', {value:value, text:text, selected:selected}));
    }
    function setConfirmMessage(e) {
        $('a.show_confirm').click(function (e) {
            var result = confirm(e.target.closest("a").getAttribute('data-message'));
            if (!result) {
                e.preventDefault();
            }
        })
    }
</script>
