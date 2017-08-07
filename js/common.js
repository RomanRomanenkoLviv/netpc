$.datepicker.regional['ru'] = {
        closeText: 'Закрыть',
        prevText: '&#x3c;Пред',
        nextText: 'След&#x3e;',
        currentText: 'Сегодня',
        monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь', 'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
        monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн', 'Июл','Авг','Сен','Окт','Ноя','Дек'],
        dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
        dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
        dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        isRTL: false,
        showOtherMonths:true,
        selectOtherMonths:true,
        changeMonth:true,
 
 
        changeYear: false,
        showAnim:"scale"
};

$.datepicker.regional['ua'] = {
        closeText: 'Закрити',
        prevText: '&#x3c;Поп',
        nextText: 'Наст&#x3e;',
        currentText: 'Сьогодні',
        monthNames: ['Січень','Лютий','Березень','Квітень','Травень','Червень', 'Липень','Серпень','Вересень','Жовтень','Листопад','Грудень'],
        monthNamesShort: ['Січ','Лют','Бер','Кві','Тра','Чер', 'Лип','Сер','Вер','Жов','Лис','Гру'],
        dayNames: ['неділя','понеділок','вівторок','середа','четвер','пятниця','субота'],
        dayNamesShort: ['нед','пон','вів','сер','чет','пят','суб'],
        dayNamesMin: ['Нд','Пн','Вт','Ср','Чт','Пт','Сб'],
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        isRTL: false,
        showOtherMonths:true,
        selectOtherMonths:true,
        changeMonth:true,
 
        yearRange: "-120:+0",
        changeYear: true,
        showAnim:"scale"
};
$.datepicker.setDefaults($.datepicker.regional['ua']);

$( "#formInputBirthdayDate" ).datepicker({
        inline: true,
        onSelect: function(dateText, inst, extensionRange) {
                $('#formInputBirthdayDate').val(dateText);
        }
});

$( "#formInputBaptismDate" ).datepicker({
        inline: true,
        onSelect: function(dateText, inst, extensionRange) {
                $('#formInputBaptismDate').val(dateText);
        }
});

$( "#formInputMembersDate" ).datepicker({
        inline: true,
        onSelect: function(dateText, inst, extensionRange) {
                $('#formInputMembersDate').val(dateText);
        }
});

$( "#formInputRetirementDate" ).datepicker({
        inline: true,
        onSelect: function(dateText, inst, extensionRange) {
                $('#formInputRetirementDate').val(dateText);
        }
});

$( "#formInputExclusionDate" ).datepicker({
        inline: true,
        onSelect: function(dateText, inst, extensionRange) {
                $('#formInputExclusionDate').val(dateText);
        }
});

$( "#formInputRemarkDate" ).datepicker({
        inline: true,
        onSelect: function(dateText, inst, extensionRange) {
                $('#formInputRemarkDate').val(dateText);
        }
});

$( "#formInputRemarkOffDate" ).datepicker({
        inline: true,
        onSelect: function(dateText, inst, extensionRange) {
                $('#formInputRemarkOffDate').val(dateText);
        }
});

$( "#formInputDeathDate" ).datepicker({
        inline: true,
        onSelect: function(dateText, inst, extensionRange) {
                $('#formInputDeathDate').val(dateText);
        }
});

$('#formInputIsRetirement').click(function(){
        var status = $(this).prop("checked");
        if(status == true){
                $('#RetirementActive').slideDown(500);
        }else{
                $('#RetirementActive').slideUp(500);
        }
});

$('#formInputIsExclusion').click(function(){
        var status = $(this).prop("checked");
        if(status == true){
                $('#ExclusionActive').slideDown(500);
        }else{
                $('#ExclusionActive').slideUp(500);
        }
});

$('#formInputIsRemark').click(function(){
        var status = $(this).prop("checked");
        if(status == true){
                $('#RemarkActive').slideDown(500);
        }else{
                $('#RemarkActive').slideUp(500);
        }
});

$('#formInputIsDeath').click(function(){
        var status = $(this).prop("checked");
        if(status == true){
                $('#DeathActive').slideDown(500);
        }else{
                $('#DeathActive').slideUp(500);
        }
});

$('.filter #pib').select2({
    tags: true,
    placeholder: "Прізвище"
});

$('.filter #district').select2({
    tags: true,
    placeholder: "Дільниця"
});

$('.filter #address_city').select2({
    tags: true,
    placeholder: "Місто/селище"
});

$('.filter #address_street').select2({
    tags: true,
    placeholder: "Вулиця"
});

$('.select_mounths').select2({
    tags: true,
    placeholder: "Місяць"
});

$('.select_years').select2({
    tags: true,
    placeholder: "Рік"
});

$('#formInputAddressCity').select2({
    placeholder: "Місто/селище",
    allowClear: true,
    tags: true,
    newTag: true
});
$('#formInputAddressStreet').select2({
    placeholder: "Вулиця",
    allowClear: true,
    tags: true,
    newTag: true
});






