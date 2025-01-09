<?php

function inc($props){
    return $props==="styles" ? '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">' : ($props==="scripts" ? '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>' : ($props==="popper" ? '<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>' : ($props==="jquery" ? '<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>' : false)));
}


function connect(){
    return mysqli_connect("localhost","root","","CVTaufikAkbar");
}

function query($sql,$q_type,$result=false){
    if($q_type==="SELECT"){
        if($result){
            $conn = connect();
            $result = mysqli_query($conn,$sql);
            $all_data = mysqli_fetch_all($result,MYSQLI_ASSOC);
            mysqli_free_result($result);
            mysqli_close($conn);
            return $all_data;
        } else {
            $conn = connect();
            $result = mysqli_query($conn,$sql);
            mysqli_free_result($result);
            mysqli_close($conn);
            return $result;
        }
    } else {
        $conn = connect();
        mysqli_query($conn,$sql);
        $affected_rows = mysqli_affected_rows($conn);
        mysqli_close($conn);
        return $affected_rows;
    }
}

/* CRUD USERS */
function delete_user($user_id){
    return query("DELETE FROM users WHERE id = $user_id","DELETE");
}

function update_user($user_id,$nama,$jenis_kelamin,$alamat,$deskripsi,$foto){
    return query("UPDATE users SET nama = '$nama', jenis_kelamin = '$jenis_kelamin', alamat = '$alamat', deskripsi = '$deskripsi', foto = '$foto' WHERE id = $user_id","UPDATE");
}

function add_user($nama,$jenis_kelamin,$alamat,$deskripsi,$foto){
    return query("INSERT INTO users (nama, jenis_kelamin, alamat, deskripsi, foto) VALUES ('$nama', '$jenis_kelamin', '$alamat', '$deskripsi', '$foto')","INSERT");
}

function get_users(){
    $sql = "SELECT id, nama, jenis_kelamin, alamat, deskripsi, foto FROM users";
}

/* CRUD ACCOUNTS */
function create_account($username,$password,$confirm_password){
    $accounts = get_accounts($username);
    if(count($accounts)==0){
        if($password===$confirm_password){
            $username=htmlspecialchars($username);
            $password=password_hash(htmlspecialchars($password), PASSWORD_DEFAULT);
            $confirm_password=password_hash(htmlspecialchars($confirm_password), PASSWORD_DEFAULT);
            $affected_rows = query("INSERT INTO accounts (`username`, `password`) VALUES ('$username', '$password')","INSERT");
            if($affected_rows>0){
                return 1;
            }
            return 0;
        }
        return -1;
    }
    return -2;
}

function get_accounts($username){
    return query("SELECT * FROM accounts WHERE username='$username'","SELECT",true);
}

function verify_login($username,$password){
    $accounts = get_accounts($username);
    $username=htmlspecialchars($username);
    $password=htmlspecialchars($password);
    // return $accounts;
    if((count($accounts)==1) && ($accounts[0]["username"]===$username)){
        $hashed_password=$accounts[0]["password"];
        $password_verify=password_verify(htmlspecialchars($password),$hashed_password);
        if($password_verify>0){
            return [
                "s"=>1,
                "id"=>$accounts[0]["id"]
            ];
        }
        return [
            "s"=>0,
            "id"=>-1
        ];
    }
    /* pesan ke admin bahwa ada username yang ganda / duplikat */
}


/* CRUD EDUCATION */
function get_educations(){
    return query("SELECT * FROM education","SELECT",true);
}

/* CRUD PROJECTS */
function delete_project($project_id){
    return query("DELETE FROM projects WHERE id = $project_id","DELETE");
}

function update_project($project_id,$nama_project,$deskripsi_project,$gambar_project,$link_project){
    return query("UPDATE projects SET nama_project = '$nama_project', deskripsi_project = '$deskripsi_project', gambar_project = '$gambar_project', link_project = '$link_project' WHERE id = $project_id","UPDATE");
}

function add_project($nama_project,$deskripsi_project,$gambar_project,$link_project){
    return query("INSERT INTO projects (nama_project, deskripsi_project, gambar_project, link_project) VALUES ('$nama_project', '$deskripsi_project', '$gambar_project', '$link_project')","INSERT");
}

function get_projects(){
    return query("SELECT * FROM projects","SELECT",true);
}

?>