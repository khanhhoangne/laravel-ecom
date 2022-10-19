window.addEventListener("swal:saveSuccess", (event) => {
    swal.fire({
        title: event.detail.title,
        text: event.detail.text,
        icon: event.detail.type,
    });

    setTimeout(() => {
        window.livewire.emit("redirect");
    }, 1000);
});

window.addEventListener("swal:confirmDelete", (event) => {
    swal.fire({
        title: event.detail.title,
        text: event.detail.text,
        icon: event.detail.type,
        showDenyButton: true,
        confirmButtonText: "Đồng ý",
        denyButtonText: "Đóng",
    }).then((result) => {
        if (result.isConfirmed) {
            window.livewire.emit("delete", event.detail.id);
            Swal.fire("Đã xóa!", "", "success");
        } else if (result.isDenied) {
            Swal.fire("Không xóa!", "", "info");
        }
    });
});
