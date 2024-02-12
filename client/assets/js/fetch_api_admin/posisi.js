let create = document.querySelector("#create");
let modal = document.querySelector("#create-position");
let update_model = document.querySelector("#update-position");
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

const getPosition = async () => {
    try {
        const tbody = document.querySelector("#tbody");
        let tr = "";
        const res = await fetch("../../api/admin/positions/index.php", {
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
                tr += `
                <tr>
                <td>${parseInt(i) + 1}</td>
                <td>${output[i].posisi}</td>
                <td>${output[i].start_date}</td>
                <td>${output[i].end_date}</td>
                <td><button onclick="editPosition(${output[i].id})" class="btn btn-sm btn-success">Edit</button>
                <button onclick="deletePosition(${output[i].id})"  class="btn btn-sm btn-danger">Delete</button></td>
                </tr>`
            }
        }
        tbody.innerHTML = tr;
    } catch (error) {
        console.log("error " + error)
    }
}
getPosition();

save.addEventListener("click", async () => {
    try {
        let posisi = document.getElementById("posisi").value;
        let start_date = document.getElementById("start_date").value;
        let end_date = document.getElementById("end_date").value;

        const res = await fetch("../../api/admin/positions/store.php", {
            method: "POST",
            body: JSON.stringify({ 
                "posisi": posisi,
                "start_date": start_date,
                "end_date": end_date
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
            posisi = "";
            start_date = "";
            end_date = "";
            modal.style.display = "none";
            getPosition();
            setTimeout(() => {
                success.style.display = "none";
                success.innerText = "";
                // window.location.href = '../../client/admin/positions.php';
            }, 1500)

        } else {
            window.scrollTo(0, 0);
            modal.style.display = "none";
            error.style.display = "flex";
            error.innerText = output.message;
            setTimeout(() => {
                error.style.display = "none";
                error.innerText = "";
                getPosition();
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
    getPosition();
});

const editPosition = async (id) => {
    update_model.style.display = "flex";

    const res = await fetch(`../../api/admin/positions/edit.php?id=${id}`, {
        method: "GET",
        headers: { 'Content-Type': 'application/json' }
    })
    const output = await res.json();
    if (output["empty"] !== "empty") {
        for (var i in output) {
            document.querySelector("#id").value = output[i].id
            document.querySelector("#edit_posisi").value = output[i].posisi
            document.querySelector("#edit_start_date").value = output[i].start_date
            document.querySelector("#edit_end_date").value = output[i].end_date
        }
    }
}


update.addEventListener("click", async () => {
    let id = document.querySelector("#id").value;
    let posisi = document.getElementById("edit_posisi").value;
    let start_date = document.getElementById("edit_start_date").value;
    let end_date = document.getElementById("edit_end_date").value;

    const res = await fetch("../../api/admin/positions/update.php", {
        method: "POST",
        body: JSON.stringify({
            "id": id,
            "posisi": posisi,
            "start_date": start_date,
            "end_date": end_date
        })
    });

    const output = await res.json();
    if (output.success) {
        window.scrollTo(0, 0);
        success.style.display = "flex";
        success.innerText = output.message;
        posisi = "";
        start_date = "";
        end_date = "";
        update_model.style.display = "none";
        getPosition();
        setTimeout(() => {
            success.style.display = "none";
            success.innerText = "";
            // window.location.href = '../../client/admin/positions.php';
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
    getPosition();
})


const deletePosition = async (id) => {
    const res = await fetch("../../api/admin/positions/delete.php?id=" + id, {
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
            // window.location.href = '../../client/admin/positions.php';
        }, 1500)
        getPosition();
    } else {
        window.scrollTo(0, 0);
        error.style.display = "flex";
        error.innerText = output.message;
        setTimeout(() => {
            error.style.display = "none";
            error.innerText = "";
        }, 1500)
    }
    getPosition();
}
