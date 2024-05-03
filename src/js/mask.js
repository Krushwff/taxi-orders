
    $(document).ready(function(){
    $('#driver_phone').mask('+7 (000) 000-00-00');
    $('#passenger_phone').mask('+7 (000) 000-00-00');
    $('#car_number').mask('а000аа00', {'translation': {
    A: {pattern: /[A-Za-z]/},
    a: {pattern: /[А-я]/},
    0: {pattern: /[0-9]/}
}});
});
