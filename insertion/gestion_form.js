

var submit = document.getElementById("submit");
var textarea = document.getElementById("textarea");
var select = document.getElementById("list_query");
var myFile = document.getElementById('myfile');
var changeSelect;
if (textarea.value == "")
{
    submit.setAttribute('disabled', true);
    textarea.setAttribute('disabled', true);
}

function disabledSubmit(booleen)
{
if(booleen)
    {
    submit.setAttribute("disabled", true);
    }
else
    {
    submit.removeAttribute('disabled');
    }
};

select.addEventListener('input', function(e)
{
    changeSelect = e.target.value;
    textarea.removeAttribute('disabled');
    if (changeSelect == "")
    {
        textarea.setAttribute('disabled', true);
        submit.setAttribute('disabled', true);
    }
    
});
textarea.addEventListener('input', function(e)
{
    if (changeSelect == 'PMID')
    {
        if(/^[0-9\n\r]+$/.test(e.target.value))
        {
            disabledSubmit(false);
        }
        else
        {
            disabledSubmit(true);
            textarea.setAttribute("oninvalid=\"alert('saisir des chiffre');\"");
        }
    }
    else if (changeSelect == 'ELocationID')
    {
        if(/^10\.[0-9]{4}\//.test(e.target.value))
        {
            disabledSubmit(false);
        }
        else
        {
            disabledSubmit(true);
        }
    }
    else if (changeSelect == 'Author')
    {
        if(/^[A-Za-z -]+$/.test(e.target.value))
        {
            disabledSubmit(false);
        }
        else
        {
            disabledSubmit(true);
        }
    }
    else if (changeSelect == 'Title')
    {
        if(/^.+$/.test(e.target.value))
        {
            disabledSubmit(false);
        }
        else
        {
            disabledSubmit(true);
        }
    }
    else if (changeSelect == 'dp')
    {
        if(/^[1-2][09][0-9]{2}$/.test(e.target.value))
        {
            disabledSubmit(false);
        }
        else
        {
            disabledSubmit(true);
        }
    }
    
});
myFile.addEventListener('change', function(e)
{
    if (e.target.value !== "")
    {
        disabledSubmit(false);
        textarea.setAttribute('disabled', true);
        select.setAttribute('disabled', true); 
    }

});





