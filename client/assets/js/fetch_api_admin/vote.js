const getUser = async () => {
    try {
        const tbody = document.querySelector("#tbody");
        let tr = "";
        const res = await fetch("../../api/admin/votes/index.php", {
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
                <td>${output[i].voter}</td>
                <td>${output[i].posisi}</td>
                <td>${output[i].kandidat}</td>
                <td>${output[i].voted_at}</td>
                </tr>`
            }
        }
        tbody.innerHTML = tr;
    } catch (error) {
        console.log("error " + error)
    }
}
getUser();