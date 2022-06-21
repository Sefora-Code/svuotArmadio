

<div class="row mt-5 pb-5">
	<div class="col-12"> <!-- start calendar -->
		<div class="row">
        	 <!--div class="col-1" id="today" style="border: 1px solid #ccc; border-radius: 5px;">
				<div class="dayNames"></div>
				<div class="days" style="font-size: 40px; margin: -15px 0;"></div>
				<div class="months"></div>                   	
            </div-->	
            @for ($i = 0; $i < 10; $i++)
        	 <div class="col-1 m-2 text-center cell-{{ $i % 2 == 0 ? 'yellow' : 'cyan' }}" id="day-{{ $i }}" style="border: 1px solid #ccc; border-radius: 5px;">
				<div class="dayNames"></div>
				<div class="days" style="font-size: 40px; margin: -15px 0;"></div>
				<div class="months"></div>
			</div>
            @endfor
		</div>
		@php
			$timeSlotsPhp = ['10:15','10:30','10:45','11:00','11:15','11:30'];
		@endphp
		@for ($i = 0; $i < 6; $i++)
		<div class="row text-center">
			@for ($j = 0; $j < 10; $j++)
            <div class="col-1 m-2 cell-{{ $j % 2 == 0 ? 'yellow' : 'cyan' }} times" id="time-{{ $i }}-{{ $j }}" style="border: 1px solid #ccc; border-radius: 5px;" onclick="setTimeSlot(this, {{ $i }}, {{ $j }})">
				<div style="font-size: 25px;" class="time-cell-{{ $j }}">{{ $timeSlotsPhp[$i] }}</div>
            </div>
			@endfor	
		</div>
		@endfor
	</div>
</div>

<script>

async function populateCalendar()
{    
	const today = new Date();
	today.setDate(today.getDate() - 1); // will be increased in the for loop

	// loop to set days values and perform 2 controls:
	// 1: for bank holidays
	// 2: for free time-slots
	for (let i=0; i < 10; i++)
	{
		today.setDate(today.getDate() + 1);
	    	
    	const parent = document.getElementById('day-'+i);
    	const children = parent.childNodes;
    
    	children[1].innerHTML = daysName[today.getDay()];
     	children[3].innerHTML = today.getDate();
    	children[5].innerHTML = getItMonth(today.getMonth());

    	// 1: verify that is not a bank holiday - synchronous fetch
    	let formattedDate = today.getFullYear()+"-"+(today.getMonth()+1)+"-"+today.getDate();
        const res = await fetch("{{ route('is_bank_holiday') }}?d="+formattedDate, {method: 'GET' });
        const response = await res.text();
	     // in case of bank holiday or saturday or sunday hide children cells
	    if (response != "-1" || today.getDay() == 0 || today.getDay() == 6)
	    {
			parent.style.background = 'transparent';
			
			const collection = document.getElementsByClassName('time-cell-'+i);
			for (let j = 0; j < collection.length; j++) 
			{
				collection[j].parentElement.style.background = 'transparent';
				collection[j].parentElement.style.border = '0 none';
				collection[j].innerHTML = "";
			}
	    }
	    else // 2: if is a working day, verify timeslot availability
	    {
	    	const collection = document.getElementsByClassName('time-cell-'+i);
			for (let j = 0; j < collection.length; j++) 
			{
				let formattedDate = today.getFullYear()+"-"+(today.getMonth()+1)+"-"+today.getDate();
				let timeslot = timeSlots[j].replace(":", "|"); // replace the colon here - but need to do the opposite on the server
				const res = await fetch("{{ route('timeslot_available') }}?d="+formattedDate+"&t="+timeslot, {method: 'GET' })
		        const response = await res.text();

				if (response == "1") // time slot NOT available				
				{
					collection[j].parentElement.classList.toggle('slotUnavailable');
					collection[j].parentElement.setAttribute('onclick', '');
				}
			}   
	    }
	}	
}



function setTimeSlot(element, hour, day)
{
	// retrieve the selected date
	const selectedDate = new Date();
	selectedDate.setDate(selectedDate.getDate() + day);

	// deselect previous element
	let selected = document.getElementsByClassName("selectedTimeSlot");
	if (selected.length > 0)
		selected[0].classList.toggle("selectedTimeSlot");
	// select new element
	element.classList.toggle("selectedTimeSlot");

	// now also set values in UI and hidden input fields
	chosenDate = selectedDate;
	showDate();
	verifyBankHoliday(selectedDate);

	chosenTime = hour;
	showTime();
	verifyAvailability();
	
}
</script>