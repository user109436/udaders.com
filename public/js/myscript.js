// $(document).ready(function() {
//     // SideNav Button Initialization
//     $(".button-collapse").sideNav({
//       slim: true,
//     });
//   });

  // console.log('script imported');
  var message=document.getElementById('message');
  function del(id, data="", msg="Are you sure ?") {
    data=data+'='+id  
   function load_questions() {
    console.log('update.php?'+data);
       $('#update').load('update.php?'+data);
      
   }
   if (confirm(msg)) {
    // console.log('data:'+data);
       $.ajax({
           type: "POST",
           async: true,
           url: "delete.php",
           data: data,
           success: function() {
               console.log('success');
               load_questions()
               message.innerHTML = "ID: " +id + " Successfully Deleted"

           }
       });
   }
}