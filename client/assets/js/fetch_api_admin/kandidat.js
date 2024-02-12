var script = document.createElement('script');

// Set the src attribute to the CDN link
script.src = 'https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js';

// Append the script element to the document body or head
document.body.appendChild(script);

let create = document.querySelector("#create");
let input_form = document.querySelector("#input_kandidat");
let update_form = document.querySelector("#update_kandidat");
let close = document.querySelector("#close")
let update_close = document.querySelector("#update_close")
let save = document.querySelector("#save");
let update = document.querySelector("#update");
let success = document.querySelector(".alert-success")
let error = document.querySelector(".alert-danger")

create.addEventListener("click", () => {
    input_form.style.display = "flex";
});

close.addEventListener("click", () => {
    input_form.style.display = "none";
});

update_close.addEventListener("click", () => {
    update_form.style.display = "none";
    create.style.display = 'flex';
    window.location.href = '../../client/admin/candidates.php';
});

save.addEventListener("click", async () => {
    try {
        let nama = document.getElementById("nama").value;
        let image = document.getElementById("image");
        let position_id = document.getElementById("posisi_kandidat").value;
        let visi = document.getElementById("visi").value;
        let misi = document.getElementById("misi").value;

        const res = await fetch("../../api/admin/candidates/store.php", {
            method: "POST",
            body: JSON.stringify({ 
                "nama": nama,
                "image": image.files[0].name,
                "position_id": position_id,
                "visi": visi, 
                "misi": misi
            }),
            headers: {
                "Content-Type": "application/json"
            }
        });

        const formData = new FormData();
        formData.append("image", image.files[0]);

        fetch("../../api/admin/candidates/store-image.php", {
            method: "POST",
            body: formData
        }).catch(console.error);

        const output = await res.json();

        if (output.success) {
            success.style.display = "flex";
            success.innerText = output.message;
            nama = "";
            image = "";
            position_id = "";
            visi = "";
            misi = "";
            getKandidat();
            // getTotalCount();
            setTimeout(() => {
                success.style.display = "none";
                success.innerText = "";
            }, 1000)
            window.location.href = '../../client/admin/candidates.php';

        } else {
            error.style.display = "flex";
            error.innerText = output.message;
            setTimeout(() => {
                error.style.display = "none";
                error.innerText = "";
            }, 1000)
        }
    } catch (err) {
        error.style.display = "flex";
        error.innerText = err.message;
        setTimeout(() => {
            error.style.display = "none";
            error.innerText = "";

        }, 1000)
    }
});

const getKandidat = async () => {
    try {
        const tbody = document.querySelector("#tbody");
        let tr = "";
        const res = await fetch("../../api/admin/candidates/index.php", {
            method: "GET",
            headers: {
                "Content-Type": "application/json"
            }
        });

        const output = await res.json();
        if (output.empty === "empty") {
            tr = "<tr><td colspan='7' style='text-align:center'>Record Not Found</td></tr>"
        } else {
            for (var i in output) {
                tr += `
                <tr>
                <td>${parseInt(i) + 1}</td>
                <td>${output[i].posisi}</td>
                <td>${output[i].nama}</td>
                <td><img src="../../client/assets/images/candidates/${output[i].image}" width="auto" height="75px" style="border-radius:10px"></td>
                <td>${output[i].visi}</td>
                <td>${output[i].misi}</td>
                <td><button onclick="editKandidat(${output[i].id})" class="btn btn-sm btn-success">Edit</button>
                <button onclick="deleteKandidat(${output[i].id})" class="btn btn-sm btn-danger">Delete</button></td>
                </tr>`
            }
        }
        tbody.innerHTML = tr;
    } catch (error) {
        console.log("error " + error)
    }
}
getKandidat();


const getPosisi = async () => {
    try {
        const option = document.querySelector("#posisi_kandidat");
        let opt = "";
        const res = await fetch("../../api/admin/positions/index.php", {
            method: "GET",
            headers: {
                "Content-Type": "application/json"
            }
        });

        const output = await res.json();
        if (output.empty === "empty") {
            opt = "<option value=''>Record Not Found</option>"
        } else {
            for (var i in output) {
                opt += `<option value='${output[i].id}'>${output[i].posisi}</option>`
            }
        }
        option.innerHTML = opt;
    } catch (error) {
        console.log("error " + error)
    }
}
getPosisi();


const editKandidat = async (id) => {
    const table = document.querySelector("#datatablesSimple");
    const btn = table.querySelectorAll('button');
    btn.forEach(button => {
        button.disabled = true;
    });

    create.style.display = 'none';
    input_form.style.display = 'none';
    update_form.style.display = 'flex';

    try {
        const option = document.querySelector("#edit_posisi_kandidat");
        let opt = "";
        const res = await fetch("../../api/admin/positions/index.php", {
            method: "GET",
            headers: {
                "Content-Type": "application/json"
            }
        });

        const output = await res.json();
        if (output.empty === "empty") {
            opt = "<option value=''>Record Not Found</option>"
        } else {
            for (var i in output) {
                opt += `<option value='${output[i].id}'>${output[i].posisi}</option>`
            }
        }
        option.innerHTML = opt;
    } catch (error) {
        console.log("error " + error)
    }

    const res = await fetch(`../../api/admin/candidates/edit.php?id=${id}`, {
        method: "GET",
        headers: { 'Content-Type': 'application/json' }
    })

    const output = await res.json();
    if (output["empty"] !== "empty") {
        for (var i in output) {
            document.querySelector("#id").value = output[i].id
            document.querySelector("#edit_nama").value = output[i].nama
            document.querySelector("#edit_posisi_kandidat").value = output[i].position_id
            document.querySelector("#gambar").value = output[i].image
            document.querySelector("#edit_visi").value = output[i].visi
            document.querySelector("#edit_misi").value = output[i].misi
            
            ClassicEditor
                .create( document.querySelector( '#edit_visi_editor' ) )
                .then( editor => {
                    const edit_visi = document.querySelector('#edit_visi');
                    window.editor = editor;
                    const editors = window.editor;
                    editors.setData(edit_visi.value);

                    editor.model.document.on('change:data', () => {
                        edit_visi.value = editor.getData();
                    });
                } )
                .catch( error => {
                    console.error( error );
                } );

            ClassicEditor
                .create( document.querySelector( '#edit_misi_editor' ) )
                .then( editor => {
                    const edit_misi = document.querySelector('#edit_misi');
                    window.editor = editor;
                    const editors = window.editor;
                    editors.setData(edit_misi.value);

                    editor.model.document.on('change:data', () => {
                        edit_misi.value = editor.getData();
                    });
                } )
                .catch( error => {
                    console.error( error );
                } );
        }
    }

}


update.addEventListener("click", async () => {
    let id = document.querySelector("#id").value;
    let nama = document.getElementById("edit_nama").value;
    let posisi = document.getElementById("edit_posisi_kandidat").value;
    let image = document.getElementById("edit_image");
    let gambarOld = document.querySelector("#gambar").value;
    let visi = document.querySelector("#edit_visi").value;
    let misi = document.querySelector("#edit_misi").value;

    let gambar;
    if (image.files[0] == undefined) {
        gambar = gambarOld;
    } else {
        gambar = image.files[0].name;
        
        const formData = new FormData();
        formData.append("image", image.files[0]);

        fetch("../../api/admin/candidates/store-image.php", {
            method: "POST",
            body: formData
        }).catch(console.error);
    }

    const res = await fetch("../../api/admin/candidates/update.php", {
        method: "POST",
        body: JSON.stringify({
            "id": id,
            "nama": nama,
            "position_id": posisi,
            "image": gambar,
            "visi": visi,
            "misi": misi
        })
    });

    const output = await res.json();
    if (output.success) {
        success.style.display = "flex";
        success.innerText = output.message;
        nama = "";
        kategori = "";
        stok = "";
        price = "1";
        image = "";
        getKandidat();
        setTimeout(() => {
            success.style.display = "none";
            success.innerText = "";
        }, 1000)
        window.location.href = '../../client/admin/candidates.php';
    } else {
        error.style.display = "flex";
        error.innerText = output.message;
        setTimeout(() => {
            error.style.display = "none";
            error.innerText = "";
        }, 1000)
    }

    input_form.style.display = 'flex';
    update_form.style.display = 'none';

})


const deleteKandidat = async (id) => {
    const res = await fetch("../../api/admin/candidates/delete.php?id=" + id, {
        method: "GET",
    });

    const output = await res.json();
    if (output.success) {
        success.style.display = "flex";
        success.innerText = output.message;
        setTimeout(() => {
            success.style.display = "none";
            success.innerText = "";
        }, 1000)
        window.location.href = '../../client/admin/candidates.php';
        getKandidat();
        // getTotalCount();
    } else {
        error.style.display = "flex";
        error.innerText = output.message;
        setTimeout(() => {
            error.style.display = "none";
            error.innerText = "";
        }, 1000)
    }
}