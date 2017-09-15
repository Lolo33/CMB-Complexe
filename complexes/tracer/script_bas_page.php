<script>
    $(window).on('beforeunload', function(e){
        var id = <?php echo $id_histo; ?>;
        $.post("tracer/histo.php", {id:id}, function (data) {
            console.log(data);
        });
        console.log("test");
    });
</script>