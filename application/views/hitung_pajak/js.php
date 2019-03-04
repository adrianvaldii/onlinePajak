<script>
    function rupiah(s){
        var number_string = s.replace(/[^.\d]/g, '').toString(),
            split   = number_string.split('.'),
            sisa    = split[0].length % 3,
            rupiah  = split[0].substr(0, sisa),
            ribuan  = split[0].substr(sisa).match(/\d{1,3}/gi);
            
        if (ribuan) {
            separator = sisa ? ',' : '';
            rupiah += separator + ribuan.join(',');
        }
        
        rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;

        return rupiah;
    }

    function fkeyup(s){
        var $input = $(s);
        var a = $input.val();
        a = rupiah(a);
        $input.val(a);
    }

    $('#addTunjangan').click(function(){
        $('<tr>'
           + '<td><input type="text" name="tunjangan_name[]" class="form-control form-control-sm"></td>'
           + '<td>&nbsp;</td>'
           + '<td>'
           +     '<input type="text" name="tunjangan_total[]" style="text-align: right" class="form-control form-control-sm" onkeyup="fkeyup(this)">'
           + '</td>'
           + '<td>'
           +     '<button type="button" class="btn btn-danger btn-sm" onclick="delete_row(this)">-</button>'
           + '</td>'
        + '</tr>').appendTo($('#tunjangan'));
    });

    $('#addPenambahan').click(function(){
        $('<tr>'
            + '<td><input type="text" name="penambahan_name[]" class="form-control form-control-sm"></td>'
            + '<td><input type="text" name="penambahan_percent[]" class="form-control form-control-sm kanan pen_percent" onkeyup="penambahan_gapok(this)"></td>'
            + '<td><input type="text" name="penambahan_total[]" class="form-control form-control-sm cs_penambahan" style="text-align: right" value="0" readonly></td>'
            + '<td><button type="button" class="btn btn-danger btn-sm" onclick="delete_row(this)">-</button></td>'
        + '</tr>').appendTo($('#penambahan'));
    });

    $('#addPengurangan').click(function(){
        $('<tr>'
            + '<td><input type="text" name="pengurangan_name[]" class="form-control form-control-sm"></td>'
            + '<td><input type="text" name="pengurangan_percent[]" class="form-control form-control-sm kanan kur_percent" onkeyup="pengurangan_gapok(this)"></td>'
            + '<td><input type="text" name="pengurangan_total[]" class="form-control form-control-sm cs_pengurangan" style="text-align: right" value="0" readonly></td>'
            + '<td><button type="button" class="btn btn-danger btn-sm" onclick="delete_row(this)">-</button></td>'
        + '</tr>').appendTo($('#pengurangan'));
    });

    function delete_row(btn)
    {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

    function changeStatus()
    {
        var status = $('#status').val();

        if (status == 1) {
            $('#anak').prop('disabled', false);
        } else {
            $('#anak').prop('disabled', 'disabled');
        }
    }

    function penambahan_gapok(id)
    {
        var input = $(id);
        var a = input.val();
        a = rupiah(a);
        input.val(a);

        var temp_gaji_pokok = $('#gaji_pokok').val();
        var gaji_pokok = temp_gaji_pokok.replace(/,/g, '');

        if (gaji_pokok == '') {
            alert('Tolong masukkan gaji pokok anda!');
        }

        var result = Math.round((a/100) * gaji_pokok);
        var result_string = result.toString();

        $(id).parent().parent().find('.cs_penambahan').val(rupiah(result_string));
    }

    function pengurangan_gapok(id)
    {
        var input = $(id);
        var a = input.val();
        a = rupiah(a);
        input.val(a);

        var temp_gaji_pokok = $('#gaji_pokok').val();
        var gaji_pokok = temp_gaji_pokok.replace(/,/g, '');

        if (gaji_pokok == '') {
            alert('Tolong masukkan gaji pokok anda!');
        }

        var result = Math.round((a/100) * gaji_pokok);
        var result_string = result.toString();

        $(id).parent().parent().find('.cs_pengurangan').val(rupiah(result_string));
    }

    $(function(){
        $('#hitungPajak').click(function(){
            // calculate tax
            $.ajax({
                type: 'POST',
                dataType: "json",
                url: '<?php echo site_url('HitungPajak/calculate_tax') ?>',
                data: $("form").serialize(),
                success: function(data)
                {
                    $('.bruto').html(rupiah(data.bruto.toString()));
                    $('.biaya_jabatan').html(rupiah(data.biaya_jabatan.toString()));
                    total_pengurangan = '(' + rupiah(data.total_pengurangan.toString()) + ')';
                    $('.total_pengurangan').html(total_pengurangan);
                    $('.netto_bulan').html(rupiah(data.netto_bulan.toString()));
                    $('.netto_tahun').html(rupiah(data.netto_tahun.toString()));
                    ptkp = '(' + rupiah(data.ptkp.toString()) + ')';
                    $('.ptkp').html(ptkp);
                    $('.kena_pajak_tahun').html(rupiah(data.kena_pajak_tahun.toString()));
                    $('.round_pajak').html(rupiah(data.round_pajak.toString()));
                    $('.pph_terutang_tahun').html('<strong>' + rupiah(data.pph_terutang_tahun.toString()) + '</strong>');
                    $('.pph_terutang_bulan').html('<strong>' + rupiah(data.pph_terutang_bulan.toString()) + '</strong>');
                    $('.percent_tahun').html(data.percent_tahun + '%');
                }
            });
        })
    });
</script>