<section class="text-white">
    @php
        date_default_timezone_set('America/Sao_Paulo');
        $currentTime = new DateTime();
        $timeZone = $currentTime->format('H:i');
        $greeting = '';

        if ($timeZone >= "00:00" and $timeZone <= "11:59") {
            $greeting = "Good morning";
        }elseif ($timeZone >= "12:00" and $timeZone <= "17:59") {
            $greeting = "Good afternoon";
        }elseif ($timeZone >= "18:00" and $timeZone <= "20:00") {
            $greeting = "Good evening";
        }else {
            $greeting = "Good night";
        }

        echo "<h1 class='font-bold text-3xl p-6'>$greeting, Fulano!!!</h1>";
    @endphp
    <div>
        <div>
            <h2>Current Value</h2>
        </div>
    </div>
</section>
