const getTotalUser = async () => {
    let total = document.querySelector("#total_user");
    const res = await fetch("../../api/admin/dashboard/totalUser.php", {
        method: "GET"
    })
    const output = await res.json();
    total.innerText = output;
}
getTotalUser();

const getTotalPosisi = async () => {
    let total = document.querySelector("#total_posisi");
    const res = await fetch("../../api/admin/dashboard/totalPosisi.php", {
        method: "GET"
    })
    const output = await res.json();
    total.innerText = output;
}
getTotalPosisi();

const getTotalKandidat = async () => {
    let total = document.querySelector("#total_kandidat");
    const res = await fetch("../../api/admin/dashboard/totalKandidat.php", {
        method: "GET"
    })
    const output = await res.json();
    total.innerText = output;
}
getTotalKandidat();

const getTotalVote = async () => {
    let total = document.querySelector("#total_vote");
    const res = await fetch("../../api/admin/dashboard/totalVote.php", {
        method: "GET"
    })
    const output = await res.json();
    total.innerText = output;
}
getTotalVote();