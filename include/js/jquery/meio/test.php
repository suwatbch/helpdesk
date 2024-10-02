<script type="text/javascript" src="../jquery-1.5.1.js" charset="utf-8"></script>
<script type="text/javascript" src="jquery.meio.mask.min.js" charset="utf-8"></script>
<script type="text/javascript">
    $(document).ready(function(){
        //$.mask.masks.dd = {mask: '99.999,999,999,999',type : 'reverse',defaultValue : ''}
       //$("input[rule]").setMask({autoTab: false, maxLength: 5});
       $('#de').setMask({autoTab: false, mask: "99.999,999,999", type: "reverse"}).val("0.00");
       

    });
//$.mask.options = options : {
//attr: 'rule', // an attr to look for the mask name or the mask itself
//mask: null, // the mask to be used on the input
//type: 'fixed', // the mask of this mask
//maxLength: -1, // the maxLength of the mask
//defaultValue: '', // the default value for this input
//textAlign: true, // to use or not to use textAlign on the input
//selectCharsOnFocus: true, //selects characters on focus of the input
//setSize: false, // sets the input size based on the length of the mask (work with fixed and reverse masks only)
//autoTab: true, // auto focus the next form element
//fixedChars : '[(),.:/ -]', // fixed chars to be used on the masks.
//onInvalid : function(){},
//onValid : function(){},
//onOverflow : function(){}
//};
//    });
</script>
<input type="text" id="time_example" rule="time" />
<br>
<input type="text" rule="dd" maxlength="5"/>
<br>
<input type="text" rule="integer" maxlength="5"/><br>
<input type="text" id="de" rule="de" maxlength="5"/>
