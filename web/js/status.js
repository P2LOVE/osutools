if($status == 'onon'){
    setInterval (blinke_funk, 2000);
function blinke_funk() {
    $('#circle').css('background', 'red');
    setTimeout (blinke_funk1, 1000);

	function blinke_funk1() { 
        $('#circle').css('background', 'white');
    }
}
}
if($status == 'offoff'){
    setInterval (blinke_funk, 2000);
function blinke_funk() {
    $('#circle').css('background', 'green');
    setTimeout (blinke_funk1, 1000);

	function blinke_funk1() { 
        $('#circle').css('background', 'white');
    }
}
}
if($status == ''){
    setInterval (blinke_funk, 2000);
function blinke_funk() {
    $('#circle').css('background', 'gray');
    setTimeout (blinke_funk1, 1000);

	function blinke_funk1() { 
        $('#circle').css('background', 'white');
    }
}
}