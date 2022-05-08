<?php
global $wpdb;
$user_list = $wpdb->get_results( 
  $wpdb->prepare("SELECT * FROM $wpdb->postmeta where meta_key = %s", 'scf_form')
); ?>

<section class="user_list">
  <h1>list of users</h1>
  <?php if($user_list){ ?>
  <input type="text" id="userSearch" onkeyup="myFunction()" placeholder="Search for email.." title="Type in a name">
    <table id="users">
        <tr>
          <th width="20">N</th>
          <th>Firstname</th>
          <th>Lastname</th>
          <th>Email</th>
          <th>Date</th>
          <th>File</th>
        </tr>
        <?php 
        $i = 1;
        foreach($user_list as $users){
          $form_data = unserialize($users->meta_value);
          ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $form_data['firstname']?></td>
            <td><?php echo $form_data['lastname']?></td>
            <td><?php echo $form_data['email']?></td>
            <td><?php echo $form_data['date']?></td>
            <td><img width="100" src='<?php echo  $form_data['file']; ?>'></td>
          </tr><?php  
        }
        ?>
    </table>
    <?php
      }else{
        $img = plugins_url('/assets/images/no-user-image-icon.jpg', SCF_MAIN_FILE);
        ?> 
        <div class="no_users_found">
          <img src="<?php echo $img; ?>">
          <h1 class="empty_list">No Users Found</h1>
        </div>
        <?php
      }
    ?>
</section>

<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("userSearch");
  filter = input.value.toUpperCase();
  table = document.getElementById("users");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[3];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>