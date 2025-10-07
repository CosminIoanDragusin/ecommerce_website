<?php 

function adminPasswordVerify($admin_pass, $conn, $admin_id){
   $sql = "SELECT * FROM users
           WHERE id=? AND role_user='admin'";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$admin_id]);

   if ($stmt->rowCount() == 1) {
     $admin = $stmt->fetch();
     $pass  = $admin['password'];

     if (password_verify($admin_pass, $pass)) {
     	return 1;
     }else {
     	return 0;
     }
   }else {
    return 0;
   }
}

// All admin
function getAllAdmins($conn){
   $sql = "SELECT * FROM users WHERE role_user='admin'";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() >= 1) {
     $admin = $stmt->fetchAll();
     return $admin;
   }else {
    return 0;
   }
}

// Get admin by ID
function getAdminById($admin_id, $conn){
   $sql = "SELECT * FROM users
           WHERE id=? AND role_user='admin'";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$admin_id]);

   if ($stmt->rowCount() == 1) {
     $admin = $stmt->fetch();
     return $admin;
   }else {
    return 0;
   }
}

// DELETE admin
function removeAdmin($admin_id, $conn){
   $sql  = "DELETE FROM users
           WHERE id=? AND role_user='admin'";
   $stmt = $conn->prepare($sql);
   $re   = $stmt->execute([$admin_id]);
   if ($re) {
     return 1;
   }else {
    return 0;
   }
}

function unameIsUnique($username, $conn, $admin_id=0){
  $sql = "SELECT username, id FROM users
          WHERE username=? AND role_user='admin'";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$username]);
  
  if ($admin_id == 0) {
    if ($stmt->rowCount() >= 1) {
      return 0;
    }else {
     return 1;
    }
  }else {
   if ($stmt->rowCount() >= 1) {
      $admin = $stmt->fetch();
      if ($admin['id'] == $admin_id) {
        return 1;
      }else {
       return 0;
     }
    }else {
     return 1;
    }
  }
  
}

function searchAdmin($key, $conn){
  $key = preg_replace('/(?<!\\\)([%_])/', '\\\$1',$key);
  $key = "%$key%"; // Add wildcards for partial matching
  $sql = "SELECT * FROM users
          WHERE role_user='admin' AND id LIKE ? 
          OR email LIKE ?
          OR username LIKE ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$key, $key, $key]);

  if ($stmt->rowCount() > 0) { // It should check for greater than 0, not == 1
    return $stmt->fetchAll();
} else {
    return 0;
}
}