$(document).ready(function (){

  // Teacher And Materials
  $('#material_teacher').click(function (e){
    e.preventDefault();
    var material = $('#inputMaterial').val();
    var teacher = $('#inputTeacher').val();
    var textMaterial = $( "#inputMaterial option:selected" ).text();
    var textTeacher = $( "#inputTeacher option:selected" ).text();
    if (material !== 'active' && teacher !== 'active') {
      $('#class_info').append("<div class='item_list'><input type='checkbox' checked name='class_info[]' value='"+material+","+teacher+"'> <label> The Material: "+textMaterial+" The Teacher: "+textTeacher+"</label></div>");
      $('#inputMaterial, #inputTeacher').val('');
    }else {
      alert('Please Choose The Material and Teacher');
    }
  });

  // Students Registration
  $('#has_teacher').on('change', function() {
    if (this.value == 'yes') {
      $('#students_users').css('display', 'block');
    }else {
      $('#students_users').css('display', 'none');
      $('#inputaddress').val('');
      $('#inputresponsble').val('');
      $('#inputresponsible_phone').val('');
      $('#inputresponsible_job').val('');
    }
  });
  // Get Teacher

  $('#teacher').on('change', function() {
    if (this.value != '0') {
      var user_id = this.value;
      var action = 'get_user';
      $.ajax({
        url: 'ajax.php',
        method: 'post',
        data: {user_id:user_id, action:action},
        dataType: "json",
        success: function(data){
          $('#inputaddress').val(data.address);
          $('#inputresponsble').val(data.first_name + ' ' + data.last_name);
          $('#inputresponsible_phone').val(data.phone);
          $('#inputresponsible_job').val(data.specialty);
        }
      });
    }
  });



});
