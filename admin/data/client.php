<?php 

function clientPasswordVerify($client_pass, $conn, $client_id){
   $sql = "SELECT * FROM users
           WHERE id=? AND role_user='client'";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$client_id]);

   if ($stmt->rowCount() == 1) {
     $client = $stmt->fetch();
     $pass  = $client['password'];

     if (password_verify($client_pass, $pass)) {
     	return 1;
     }else {
     	return 0;
     }
   }else {
    return 0;
   }
}

// All client
function getAllClients($conn){
   $sql = "SELECT * FROM users WHERE role_user='client'";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() >= 1) {
     $client = $stmt->fetchAll();
     return $client;
   }else {
    return 0;
   }
}

// Get client by ID
function getClientById($client_id, $conn){
   $sql = "SELECT * FROM users
           WHERE id=? AND role_user='client'";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$client_id]);

   if ($stmt->rowCount() == 1) {
     $client = $stmt->fetch();
     return $client;
   }else {
    return 0;
   }
}

// DELETE client
function removeClient($client_id, $conn){
   $sql  = "DELETE FROM users
           WHERE id=? AND role_user='client'";
   $stmt = $conn->prepare($sql);
   $re   = $stmt->execute([$client_id]);
   if ($re) {
     return 1;
   }else {
    return 0;
   }
}

function unameIsUnique($username, $conn, $client_id=0){
  $sql = "SELECT username, id FROM users
          WHERE username=? AND role_user='client'";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$username]);
  
  if ($client_id == 0) {
    if ($stmt->rowCount() >= 1) {
      return 0;
    }else {
     return 1;
    }
  }else {
   if ($stmt->rowCount() >= 1) {
      $client = $stmt->fetch();
      if ($client['id'] == $client_id) {
        return 1;
      }else {
       return 0;
     }
    }else {
     return 1;
    }
  }
  
}

function searchClient($key, $conn){
  $key = preg_replace('/(?<!\\\)([%_])/', '\\\$1',$key);
  $key = "%$key%"; // Add wildcards for partial matching
  $sql = "SELECT * FROM users
          WHERE role_user='client' AND id LIKE ? 
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