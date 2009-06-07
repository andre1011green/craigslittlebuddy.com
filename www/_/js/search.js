function setNumCustomCities ()
{
    var s = document.getElementById ('customNumCities');
    s.innerHTML = 9;
}

function checkAll (frmName)
{
    var frm = document.forms[frmName];

    for (var i = 0; i < frm.elements.length; i++)
    {
        if (frm.elements[i].type.indexOf ('check') == 0)
        {
            frm.elements[i].checked = true;
        }
    }
    
    var a = document.getElementById ('cityDialogCheckAll');
    a.innerHTML = 'deselect all';
    a.href = 'javascript: unCheckAll ("' + frmName + '");';
}

function unCheckAll (frmName)
{
    var frm = document.forms[frmName];

    for (var i = 0; i < frm.elements.length; i++)
    {
        if (frm.elements[i].type.indexOf ('check') == 0)
        {
            frm.elements[i].checked = false;
        }
    }
    
    var a = document.getElementById ('cityDialogCheckAll');
    a.innerHTML = 'select all';
    a.href = 'javascript: checkAll ("' + frmName + '");';
}

function checkDefault ()
{
    var a = [];
    
    a['atlanta'] = true;
    a['austin'] = true;
    a['boston'] = true;
    a['chicago'] = true;
    a['denver'] = true;
    a['houston'] = true;
    a['lasvegas'] = true;
    a['losangeles'] = true;
    a['miami'] = true;
    a['minneapolis'] = true;
    a['newyork'] = true;
    a['orangecounty'] = true;
    a['philadelphia'] = true;
    a['phoenix'] = true;
    a['portland'] = true;
    a['raleigh'] = true;
    a['sacramento'] = true;
    a['sandiego'] = true;
    a['sfbay'] = true;
    a['seattle'] = true;
    a['washingtondc'] = true;
    
    var frm = document.forms['cityDialogForm'];
    unCheckAll ('cityDialogForm');
    
    for (var i = 0; i < frm.elements.length; i++)
    {
        if ((frm.elements[i].type.indexOf ('check')) == 0 && a[frm.elements[i].value])
        {
            frm.elements[i].checked = true;
        }
    }    
}

function showLoading ()
{
    var m = document.getElementById ('main');
    var l = document.getElementById ('loading');
    
    m.style.display = "none";
    l.style.display = "inline";
    l.style.width = "700px";
}

var i = new Image ();
i.src = '/_/images/loading-bar.gif';