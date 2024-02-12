let create = document.querySelector("#create");
let modal = document.querySelector("#create-user");
let update_model = document.querySelector("#update-user");
let close = document.querySelector("#close")
let update_close = document.querySelector("#update_close")
let save = document.querySelector("#save");
let update = document.querySelector("#update");
let success = document.querySelector(".alert-success")
let error = document.querySelector(".alert-danger")


create.addEventListener("click", () => {
    modal.style.display = "flex";
});
close.addEventListener("click", () => {
    modal.style.display = "none";
})
update_close.addEventListener("click", () => {
    update_model.style.display = "none";

})

const getUser = async () => {
    try {
        const tbody = document.querySelector("#tbody");
        let tr = "";
        let isAdmin = "";
        const res = await fetch("../../api/admin/users/index.php", {
            method: "GET",
            headers: {
                "Content-Type": "application/json"
            }
        });

        const output = await res.json();
        if (output.empty === "empty") {
            tr = "<tr><td colspan='5' style='text-align:center'>Record Not Found</td></tr>"
        } else {
            for (var i in output) {
                if (output[i].is_admin == 0) {
                    isAdmin = 'User'
                } else {
                    isAdmin = 'Admin'
                }
                tr += `
                <tr>
                <td>${parseInt(i) + 1}</td>
                <td>${output[i].email}</td>
                <td>${output[i].nama}</td>
                <td>${isAdmin}</td>
                <td><button onclick="editUser(${output[i].id})" class="btn btn-sm btn-success">Edit</button>
                <button onclick="deleteUser(${output[i].id})"  class="btn btn-sm btn-danger">Delete</button></td>
                </tr>`
            }
        }
        tbody.innerHTML = tr;
    } catch (error) {
        console.log("error " + error)
    }
}
getUser();

save.addEventListener("click", async () => {
    try {
        let email = document.getElementById("email").value;
        let nama = document.getElementById("nama").value;
        let password = document.getElementById("password").value;

        const res = await fetch("../../api/admin/users/store.php", {
            method: "POST",
            body: JSON.stringify({ 
                "email": email,
                "nama": nama,
                "password": password
            }),
            headers: {
                "Content-Type": "application/json"
            }
        });

        const output = await res.json();

        if (output.success) {
            window.scrollTo(0, 0);
            success.style.display = "flex";
            success.innerText = output.message;
            email = "";
            nama = "";
            password = "";
            modal.style.display = "none";
            getUser();
            setTimeout(() => {
                success.style.display = "none";
                success.innerText = "";
                // window.location.href = '../../client/admin/users.php';
            }, 1500)

        } else {
            window.scrollTo(0, 0);
            modal.style.display = "none";
            error.style.display = "flex";
            error.innerText = output.message;
            setTimeout(() => {
                error.style.display = "none";
                error.innerText = "";
                getUser();
            }, 1500)
        }
    } catch (err) {
        window.scrollTo(0, 0);
        modal.style.display = "none";
        error.style.display = "flex";
        error.innerText = err.message;
        setTimeout(() => {
            error.style.display = "none";
            error.innerText = "";

        }, 1500)
    }
    getUser();
});

const editUser = async (id) => {
    update_model.style.display = "flex";

    const res = await fetch(`../../api/admin/users/edit.php?id=${id}`, {
        method: "GET",
        headers: { 'Content-Type': 'application/json' }
    })
    const output = await res.json();
    if (output["empty"] !== "empty") {
        for (var i in output) {
            document.querySelector("#id").value = output[i].id
            document.querySelector("#edit_email").value = output[i].email
            document.querySelector("#edit_nama").value = output[i].nama
        }
    }
}


update.addEventListener("click", async () => {
    let id = document.querySelector("#id").value;
    let email = document.getElementById("edit_email").value;
    let nama = document.getElementById("edit_nama").value;
    let password = document.getElementById("edit_password").value;

    const res = await fetch("../../api/admin/users/update.php", {
        method: "POST",
        body: JSON.stringify({
            "id": id,
            "email": email,
            "nama": nama,
            "password": password
        })
    });

    const output = await res.json();
    if (output.success) {
        window.scrollTo(0, 0);
        success.style.display = "flex";
        success.innerText = output.message;
        email = "";
        nama = "";
        password = "";
        update_model.style.display = "none";
        getUser();
        setTimeout(() => {
            success.style.display = "none";
            success.innerText = "";
            // window.location.href = '../../client/admin/users.php';
        }, 1500)
        
    } else {
        window.scrollTo(0, 0);
        error.style.display = "flex";
        error.innerText = output.message;
        setTimeout(() => {
            error.style.display = "none";
            error.innerText = "";
        }, 1500)
    }
    getUser();
})


const deleteUser = async (id) => {
    const res = await fetch("../../api/admin/users/delete.php?id=" + id, {
        method: "GET",
    });

    const output = await res.json();
    if (output.success) {
        window.scrollTo(0, 0);
        success.style.display = "flex";
        success.innerText = output.message;
        setTimeout(() => {
            success.style.display = "none";
            success.innerText = "";
            // window.location.href = '../../client/admin/users.php';
        }, 1500)
    } else {
        window.scrollTo(0, 0);
        error.style.display = "flex";
        error.innerText = output.message;
        setTimeout(() => {
            error.style.display = "none";
            error.innerText = "";
        }, 1500)
    }
    getUser();
}
