const getPosisi = async () => {
    try {
        const div_chart = document.querySelector("#div_chart");
        let content = "";
        
        const res = await fetch("../../api/user/posisi.php", {
            method: "GET",
            headers: {
                "Content-Type": "application/json"
            }
        });

        const output = await res.json();
        if (output.empty === "empty") {
            content = "<h5>Record Not Found</h5>"
        } else {
            for (var i in output) {
                content += `
                <div class="col-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fas fa-check-to-slot me-1"></i>
                            ${output[i].posisi}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <center><h5>Kandidat:</h5></center>
                                <div class="row" id="div_kandidat(${output[i].id})">
                                    
                                </div>
                                <div class="container-alert mt-2">
                                    <div class="alerts">
                                        <div class="alert alert-success" id="success(${output[i].id})">Anda sudah melakukan Vote.</div>
                                        <div class="alert alert-danger" id="danger(${output[i].id})">Anda belum melakukan Vote.</div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col">
                                        <center>
                                            <h6>Awal Voting:</h6>
                                            <p>${output[i].start_date}</p>
                                        </center>
                                    </div>
                                    <div class="col">
                                        <center>
                                            <h6>Akhir Voting:</h6>
                                            <p>${output[i].end_date}</p>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <center>
                                <a href="detail-chart.php?id=${output[i].id}" class="btn btn-primary mt-2">Lihat Chart Perolehan Suara</a>
                            </center>
                        </div>
                    </div>
                </div>`;
                getKandidat(`${output[i].id}`);
            }
        }
        div_chart.innerHTML = content;
    } catch (error) {
        console.log("error " + error)
    }
}
getPosisi();

const getKandidat = async (position_id) => {
    try {
        // const div_posisi = document.querySelector("#posisi_kandidat");
        let content = "";
        const res = await fetch(`../../api/user/kandidat.php?position_id=${position_id}`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json"
            }
        });

        const output = await res.json();
        if (output.empty === "empty") {
            content = "<h5>Record Not Found</h5>"
        } else {
            for (var i in output) {
                content += `
                <div class="col-6">
                    <div class="card mb-1" style="padding:10px">
                        <center>
                            <h6>${output[i].nama}</h6>
                            <img src="../assets/images/candidates/${output[i].image}" width="80%" height="auto" style="border-radius: 5px">
                        </center>
                    </div>
                </div>`;
                document.getElementById(`div_kandidat(${output[i].position_id})`).innerHTML = content;
            }
        }
        // document.querySelector("#div_kandidat(${output[i].id})").innerHTML = content;
    } catch (error) {
        console.log("error " + error)
    }
}