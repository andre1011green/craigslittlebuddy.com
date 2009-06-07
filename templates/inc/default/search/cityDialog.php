<script type="text/javascript" src="http://yui.yahooapis.com/2.5.1/build/yahoo-dom-event/yahoo-dom-event.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.5.1/build/connection/connection-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.5.1/build/element/element-beta-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.5.1/build/button/button-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.5.1/build/container/container-min.js"></script>

<div id="cityDialog">
    <div class="hd">Pick Which Cities You Wanna Search</div>
    <div class="bd">
        <form name="cityDialogForm" method="POST" action="/ajax/saveCityConfig">
            <div class="controls">
                <a id="cityDialogCheckAll" href="javascript: checkAll ('cityDialogForm', 'cityDialogCheckAll')">select all</a>
                &nbsp;
                <a href="javascript: checkDefault ()">restore default</a><br />&nbsp;
            </div>
            
            <div class="cityHolder">
                <?
                    $allCities = CLUtil::getAllCities ();
                    $usedCities = CLUtil::getUsedCities ();
                    $defaultCities = CLUtil::getDefaultCities ();
                    
                    foreach ($allCities as $domain => $label)
                    {
                        $sel = (array_search ($domain, $usedCities) !== false) ? 'checked="true"' : '';
                        $class = ($defaultCities[$domain]) ? 'bold' : '';
                        
                        echo "<div class=\"dialogCity\">",
                                "<input type=\"checkbox\" id=\"cityDialog_{$domain}\" name=\"city[$domain]\" value=\"$domain\" $sel>&nbsp;",
                                "<label class=\"{$class}\" for=\"cityDialog_{$domain}\">{$label}</label>",
                                "</div>";                   
                    }
                ?>
                <br class="clear" />
            </div>
        </form>
    </div>
</div>

<script>
    var submitOnSave = false;
    var cityDialog = new YAHOO.widget.Dialog("cityDialog"); 

    cityDialog.cfg.setProperty("fixedcenter", true);
    cityDialog.cfg.setProperty ("modal", true);
    cityDialog.cfg.setProperty ("close", true);
    cityDialog.cfg.setProperty ("postmethod", "async");
    
    cityDialog.callback.success = function () {if (submitOnSave) document.forms['mainForm'].submit ();};
    cityDialog.callback.failure = function () {};
    
    function showCityDialog()
    {
        cityDialog.show ();  
        cityDialog.cfg.setProperty ("buttons", cityButtons);
    }
    
    var handleCancel = function () {
        this.cancel ();
    }
    var handleSubmit = function () {
        this.submit ();
    }
    var handleSubmitAndSearch = function () {
        submitOnSave = true;
        showLoading ();
        this.submit ();
    }
    var cityButtons = [ 
                        { text:"Save & Search", handler:handleSubmitAndSearch, isDefault:true },
                        { text:"Save", handler:handleSubmit, isDefault:false },
                        { text:"Cancel", handler:handleCancel } ];
                        
    var showCityDialogLink = document.getElementById ('showCityDialogLink');
    var showCityDialogLink2 = document.getElementById ('showCityDialogLink2');
    showCityDialogLink.href = "javascript: showCityDialog()";
    showCityDialogLink2.href = "javascript: showCityDialog()";
                      
</script>    