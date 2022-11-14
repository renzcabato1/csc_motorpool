
<script>
    var equipments = {!! json_encode($equipments->toArray()) !!};
    var locations = {!! json_encode($locations->toArray()) !!};
    function start_data(data)
    {
        var d = data.split('-');
        var fuel = equipments[d[1]].fuel;
        
        if(fuel.length == 0)
        {
            document.getElementById("date_fuel").min = "";
            document.getElementById("starting_odometer").value = "No previous data";
            document.getElementById("ending_odometer").min = "";
        }
        else
        {
            console.log(fuel[0].date_fuel);
            document.getElementById("date_fuel").min = fuel[0].date_fuel+1;
            document.getElementById("starting_odometer").value = fuel[0].ending_odometer;
            document.getElementById("ending_odometer").min = fuel[0].ending_odometer;
        }
    }
    function get_fuel_active(data)
    {
        var idSample = parseInt(data);
        var item = locations.find(item => item.id === idSample);
        if(item.location_type == "DIRECT SUPPLIER")
        {
            document.getElementById("total_liters").max = item.actual_fuel;

var d = item.actual_fuel;
document.getElementById("available_fuel").value = d;
        }
        else
        {
            document.getElementById("total_liters").max = item.actual_fuel;

            var d = item.actual_fuel;
            document.getElementById("available_fuel").value = d;
        }
    }
    function get_fuel_balance(data)
    {
        var idSample = parseInt(data);
        var item = locations.find(item => item.id === idSample);
        console.log(item.actual_fuel);
        document.getElementById("ending_balance").innerHTML = item.actual_fuel;
    }
</script>