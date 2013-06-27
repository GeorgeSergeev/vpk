    <div class=logoarea>

        <!-- логотип:  class=logo_en для english -->
        <div class=logo<?=GetCurrentLang($LANG) ?>><a href=''></a></div>

        <!-- форма поиска -->
        <div class=search>
            <form name=searchform action='' method=POST>
                <input name=word>
                <div class=go onclick='document.searchform.submit()'></div>
            </form>
        </div>
        <!-- конец формы поиска -->

    </div>
