<script type="text/javascript">
    function updateTextInput1(val) { // visar vad slidern Age_1 är stäld på för tal
      document.getElementById('textInput1').value=val; 
    }
	function updateTextInput2(val) {// visar vad slidern Age_2 är stäld på för tal
      document.getElementById('textInput2').value=val; 
    }
	var k;
	function showResults(k){ // visar 10 sökresultat per sida Gömmer de som inte visas
		y= (k*10);
			if(k == 1) { // spec för första sidan då det buggade sig för den samt att det klagar på minus värden
						for (i = 0; i <= 9; i++) {
							document.getElementById(i).style.display = "block"; // visar aktivitet 0 till och med 9 (10 styck)
						}
						for (i = 10; i < 1000; i++) { 
						   document.getElementById(i).style.display = "none"; // Döljer aktivitet 10 till och med "ma"+1 vilket är antal träfar +1 då det ska vara möjligt att visa sista utan special fall för det med 
						}
				} else {
					for (i = 0; i <= y-11; i++) { 
					   document.getElementById(i).style.display = "none"; // döljer aktiviteterna 0 till och med y-11 (((sidnumer*10)-11) för att dölja de "tidigare" än de jag vill visa
					}
					for (i = y-10; i < y; i++) {
						document.getElementById(i).style.display = "block"; // visar aktivitet y-10((sidnumer*10)-10)  till och med 10 stycken frammåt 
					}
					for (i = y; i < 1000; i++) { 
					   document.getElementById(i).style.display = "none";// Döljer aktivitet y(sidnumer*10) till och med "ma"+1 vilket är antal träfar +1 då det ska vara möjligt att visa sista utan special fall för det med 
					}
			}
	}
	function showPast() { // planerad för att blädra 10 aktiviteter fram
		
	}
	function showNext() {// planerad för att blädra 10 aktiviteter back
		
	}
  </script>