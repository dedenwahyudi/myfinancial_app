$(document).ready(function () {
	// Hanya memanggil halaman yang di load (Start)
	$(".nav-link-ajax").on("click", function (e) {
		e.preventDefault();

		var url = $(this).attr("href");

		$.ajax({
			url: url,
			type: "GET",
			success: function (response) {
				$("#main").html(response);

				// Menghapus attribute required saat checkbox di checklist : v_data_pemasukan (Start)
				$("#tanpa_bukti").change(function () {
					if ($(this).is(":checked")) {
						$("#bukti").removeAttr("required");
						$("#bukti").val("");
					} else {
						$("#bukti").attr("required", "required");
					}
				});

				$("#bukti").change(function () {
					if ($(this).val()) {
						$("#tanpa_bukti").prop("checked", false);
					}
				});
				// Menghapus attribute required saat checkbox di checklist : v_data_pemasukan (End)

				// Menghapus attribute required saat checkbox di checklist : v_data_pengeluaran (Start)
				$("#tanpa_bukti").change(function () {
					if ($(this).is(":checked")) {
						$("#bukti_pengeluaran").removeAttr("required");
						$("#bukti_pengeluaran").val("");
					} else {
						$("#bukti_pengeluaran").attr("required", "required");
					}
				});

				$("#bukti_pengeluaran").change(function () {
					if ($(this).val()) {
						$("#tanpa_bukti").prop("checked", false);
					}
				});
				// Menghapus attribute required saat checkbox di checklist : v_data_pengeluaran (End)

				$("#jumlah").on("input", function () {
					var value = $(this).val();
					var formattedValue = formatRupiah(value);
					$(this).val(formattedValue);
				});

				$("#jumlah_bayar").on("input", function () {
					var value = $(this).val();
					var formattedValue = formatRupiah(value);
					$(this).val(formattedValue);
				});

				$("#nominal").on("input", function () {
					var value = $(this).val();
					var formattedValue = formatRupiah(value);
					$(this).val(formattedValue);
				});

				$("#edit_jumlah_bayar").on("input", function () {
					var value = $(this).val();
					var formattedValue = formatRupiah(value);
					$(this).val(formattedValue);
				});

				$("#edit_jumlah1").on("input", function () {
					var value = $(this).val();
					var formattedValue = formatRupiah(value);
					$(this).val(formattedValue);
				});

				$("#jumlah_pengeluaran").on("input", function () {
					var value = $(this).val();
					var formattedValue = formatRupiah(value);
					$(this).val(formattedValue);
				});

				// v_data_pengeluaran : Sisa Saldo - Jumlah (Start)
				var sisaSaldoAwal1 = parseInt($("#sisa_saldo_awal1").val());

				$("#jumlah_pengeluaran").on("input", function () {
					var jumlahPengeluaran1 = $(this)
						.val()
						.replace(/[^0-9]/g, "");
					jumlahPengeluaran1 = parseInt(jumlahPengeluaran1) || 0;

					if (jumlahPengeluaran1 > sisaSaldoAwal1) {
						$("#error_message").show();
						jumlahPengeluaran1 = Math.floor(jumlahPengeluaran1 / 10);
						$(this).val("Rp. " + jumlahPengeluaran1.toLocaleString("id-ID"));
					} else {
						$("#error_message").hide();
						var newSaldo = sisaSaldoAwal1 - jumlahPengeluaran1;
						$("#sisa_saldo").val(
							"Rp. " + newSaldo.toLocaleString("id-ID") + ",-"
						);
						$(this).val("Rp. " + jumlahPengeluaran1.toLocaleString("id-ID"));
					}
				});
				// v_data_pengeluaran : Sisa Saldo - Jumlah (End)

				// v_data_history_pengeluaran : Sisa Saldo - Jumlah (Start)
				var sisaSaldoAwal2 = parseInt($("#sisa_saldo_awal2").val());

				$("#edit_jumlah_history_pengeluaran1").on("input", function () {
					var jumlahPengeluaran2 = $(this)
						.val()
						.replace(/[^0-9]/g, "");
					jumlahPengeluaran2 = parseInt(jumlahPengeluaran2) || 0;

					if (jumlahPengeluaran2 > sisaSaldoAwal2) {
						$("#error_message").show();
						jumlahPengeluaran2 = Math.floor(jumlahPengeluaran2 / 10);
						$(this).val("Rp. " + jumlahPengeluaran2.toLocaleString("id-ID"));
					} else {
						$("#error_message").hide();
						var newSaldo = sisaSaldoAwal2 - jumlahPengeluaran2;
						$("#sisa_saldo").val(
							"Rp. " + newSaldo.toLocaleString("id-ID") + ",-"
						);
						$(this).val("Rp. " + jumlahPengeluaran2.toLocaleString("id-ID"));
					}
				});

				$("#edit_jumlah_history_pengeluaran1").on("input", function () {
					var value = $(this).val();
					var formattedValue = formatRupiah(value);
					$(this).val(formattedValue);
				});
				// v_data_history_pengeluaran : Sisa Saldo - Jumlah (End)

				$("#jumlah_budget").on("input", function () {
					var value = $(this).val();
					var formattedValue = formatRupiah(value);
					$(this).val(formattedValue);
				});

				// Detail Planning : v_planning.php
				let currentIndex = 1;
				$("#btn_add_detail_anggaran").click(function () {
					var detailRow = `
									<div class="row mb-2 detail-row">
										<div class="col-5">
											<input type="text" class="form-control" name="item_planning[${currentIndex}]" id="item_planning_${currentIndex}" placeholder="Item" autocomplete="off" required>
										</div>
										<div class="col-5">
											<input type="text" class="form-control estimasi_harga" name="estimasi_harga[${currentIndex}]" id="estimasi_harga_${currentIndex}" placeholder="Rp. 0" autocomplete="off" required>
										</div>
										<div class="col-2 d-flex align-items-end">
											<button class="btn btn-outline-danger col-12 btn_delete_detail" type="button"><i class="ri-delete-bin-6-line"></i></button>
										</div>
									</div>`;
					$("#detail_container").append(detailRow);
					currentIndex += 1;
				});

				$(document).on("input", ".estimasi_harga", function () {
					calculateTotal();
				});

				$("#jumlah_anggaran_planning").on("input", function () {
					var value = $(this).val();
					var formattedValue = formatRupiah(value);
					$(this).val(formattedValue);
				});

				$("#edit_jumlah_budget1").on("input", function () {
					var value = $(this).val();
					var formattedValue = formatRupiah(value);
					$(this).val(formattedValue);
				});

				// Otomatis Mengisi Kolom Belum di Bayar : v_data_tagihan.php (Start)
				$("#sudah_dibayar").on("input", function () {
					var jumlahTenor = parseInt($("#jumlah_tenor").val(), 10) || 0;
					var sudahDibayar = parseInt($(this).val(), 10) || 0;

					if (sudahDibayar > jumlahTenor) {
						$(this).val(jumlahTenor);
						sudahDibayar = jumlahTenor;
					}

					$("#belum_dibayar").val(jumlahTenor - sudahDibayar);
				});

				$("#edit_sudah_dibayar").on("input", function () {
					var editJumlahTenor =
						parseInt($("#edit_jumlah_tenor").val(), 10) || 0;
					var editSudahDibayar = parseInt($(this).val(), 10) || 0;

					if (editSudahDibayar > editJumlahTenor) {
						$(this).val(editJumlahTenor);
						editSudahDibayar = editJumlahTenor;
					}

					$("#edit_belum_dibayar").val(editJumlahTenor - editSudahDibayar);
				});
				// Otomatis Mengisi Kolom Belum di Bayar : v_data_tagihan.php (End)
				$("");
			},
			error: function () {
				Swal.fire("Error loading page");
			},
		});
	});
	// Hanya memanggil halaman yang di load (End)

	// Preview Foto Profile : v_user_profile (Start)
	$("#foto_baru").change(function () {
		readURL(this);
	});

	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$("#preview_foto").attr("src", e.target.result).show();
			};

			reader.readAsDataURL(input.files[0]); // Membaca data URL gambar
		}
	}
	// Preview Foto Profile : v_user_profile (End)
});

// Tampil Data : v_data_pemasukan
function openDetailPemasukan(id_pemasukan) {
	$.ajax({
		url: base_url + "C_data_pemasukan/get_data_pemasukan_by_id",
		method: "POST",
		data: {
			id_pemasukan: id_pemasukan,
		},
		dataType: "JSON",
		success: function (data) {
			var status = data[0].status;

			var jml = data[0].jumlah;
			var jumlah = formatIDR(jml);

			var tgl = data[0].tanggal;
			var tanggal = ubahFormatTanggal(tgl);

			var bukti = data[0].file_path;

			if (status == 0) {
				status = "Open";
			} else if (status == 1) {
				status = "Belum di Review";
			} else if (status == 2) {
				status = "Sudah di Review";
			}

			$("#td_tanggal").text(tanggal);
			$("#td_sumber_dana").text(data[0].sumber_dana);
			$("#td_tujuan").text(data[0].tujuan);
			$("#td_keterangan").text(data[0].keterangan);
			$("#td_jumlah").text(jumlah);
			$("#td_bukti").html(
				'<a href="' + data[0].file_path + '" target="_blank">Lihat</a>'
			);
			$("#span_status").text(status);
		},
	});
	$("#modal_detail_data_pemasukan").modal("show");
}

// Tampil Data : v_data_pengeluaran
function openDetailDataPengeluaran(id_pengeluaran) {
	$.ajax({
		url: base_url + "C_data_pengeluaran/get_data_pengeluaran_by_id",
		method: "POST",
		data: {
			id_pengeluaran: id_pengeluaran,
		},
		dataType: "JSON",
		success: function (data) {
			var status = data[0].status;

			var jml = data[0].jumlah;
			var jumlah = formatIDR(jml);

			var tgl = data[0].tanggal;
			var tanggal = ubahFormatTanggal(tgl);

			if (status == 0) {
				status = "Open";
			} else if (status == 1) {
				status = "Belum di Review";
			} else if (status == 2) {
				status = "Sudah di Review";
			}

			$("#td_tanggal_pengeluaran").text(tanggal);
			$("#td_jenis_pengeluaran").text(data[0].jenis);
			$("#td_jumlah_pengeluaran").text(jumlah);
			$("#td_keterangan_pengeluaran").text(data[0].keterangan);
			$("#td_bukti_pengeluaran").html(
				'<a href="' + data[0].file_path + '" target="_blank">Lihat</a>'
			);
			$("#span_status_pengeluaran").text(status);
		},
	});
	$("#modal_detail_data_pengeluaran").modal("show");
}

// Tampil Data : v_history_data_pemasukan
function openDetailHistoryDataPemasukan(id_pemasukan) {
	$.ajax({
		url: base_url + "C_data_pemasukan/get_data_pemasukan_by_id",
		method: "POST",
		data: {
			id_pemasukan: id_pemasukan,
		},
		dataType: "JSON",
		success: function (data) {
			var status = data[0].status;

			var jml = data[0].jumlah;
			var jumlah = formatIDR(jml);

			var tgl = data[0].tanggal;
			var tanggal = ubahFormatTanggal(tgl);

			if (status == 0) {
				status = "Open";
			} else if (status == 1) {
				status = "Belum di Review";
			} else if (status == 2) {
				status = "Sudah di Review";
			}

			$("#td_history_tanggal").text(tanggal);
			$("#td_history_sumber_dana").text(data[0].sumber_dana);
			$("#td_history_tujuan").text(data[0].tujuan);
			$("#td_history_keterangan").text(data[0].keterangan);
			$("#td_history_jumlah").text(jumlah);
			$("#td_history_bukti").html(
				'<a href="' + data[0].file_path + '" target="_blank">Lihat</a>'
			);
			$("#span_history_status").text(status);
		},
	});
	$("#modal_detail_history_data_pemasukan").modal("show");
}

// Tampil Data : v_histpry_data_pengeluaran
function openDetailHistoryDataPengeluaran(id_pengeluaran) {
	$.ajax({
		url: base_url + "C_data_pengeluaran/get_data_pengeluaran_by_id",
		method: "POST",
		data: {
			id_pengeluaran: id_pengeluaran,
		},
		dataType: "JSON",
		success: function (data) {
			var status = data[0].status;

			var jml = data[0].jumlah;
			var jumlah = formatIDR(jml);

			var tgl = data[0].tanggal;
			var tanggal = ubahFormatTanggal(tgl);

			if (status == 0) {
				status = "Open";
			} else if (status == 1) {
				status = "Belum di Review";
			} else if (status == 2) {
				status = "Sudah di Review";
			}

			$("#td_history_tanggal_pengeluaran").text(tanggal);
			$("#td_history_jenis_pengeluaran").text(data[0].jenis);
			$("#td_history_jumlah_pengeluaran").text(jumlah);
			$("#td_history_keterangan_pengeluaran").text(data[0].keterangan);
			$("#td_history_bukti_pengeluaran").html(
				'<a href="' + data[0].file_path + '" target="_blank">Lihat</a>'
			);
			$("#span_history_status_pengeluaran").text(status);
		},
	});
	$("#modal_detail_history_data_pengeluaran").modal("show");
}

// Tampil Data : v_data_planning
function openDetailDataPlanning(id_planning) {
	$.ajax({
		url: base_url + "C_data_planning/get_data_planning_detail_by_id",
		method: "POST",
		data: {
			id_planning: id_planning,
		},
		dataType: "JSON",
		success: function (data) {
			let tableBody = "";
			data.forEach(function (item) {
				tableBody += `
								<tr>
                                <td>${item.nama_item}</td>
                                <td class="text-center">:</td>
                                <td>${formatIDR(item.estimasi_harga)}</td>
                              </tr>`;
			});
			$("#detail_data_planning_body").html(tableBody);
		},
	});

	$.ajax({
		url: base_url + "C_data_planning/get_data_planning_by_id",
		method: "POST",
		data: {
			id_planning: id_planning,
		},
		dataType: "JSON",
		success: function (data) {
			$("#total_estimasi_planning").text(formatIDR(data[0].total_estimasi));
		},
	});
	$("#modal_detail_data_planning").modal("show");
}

// Edit Foto Profile : v_user_profile
// let cropper;

function openEditFotoProfile() {
	$("#modal_edit_foto_profile").modal("show");
}

// Edit Data : v_history_data_pemasukan
function openEditHistoryDataPemasukan(id_pemasukan) {
	$.ajax({
		url: base_url + "C_data_pemasukan/get_data_pemasukan_by_id",
		method: "POST",
		data: {
			id_pemasukan: id_pemasukan,
		},
		dataType: "JSON",
		success: function (data) {
			$("#id_pemasukan").val(data[0].id_pemasukan);
			$("#edit_tanggal").val(data[0].tanggal);
			$("#edit_sumber_dana").val(data[0].sumber_dana);
			$("#edit_tujuan").val(data[0].tujuan);
			$("#edit_keterangan").val(data[0].keterangan);
			$("#edit_jumlah2").val(formatIDR(data[0].jumlah));
			$("#foto_lama").val(data[0].file_path);
			$("#current_image_history").attr("src", data[0].file_path);
		},
	});
	$("#modal_edit_history_data_pemasukan").modal("show");
}

// Edit Data : v_history_data_pengeluaran
function openEditHistoryDataPengeluaran(id_pengeluaran) {
	$.ajax({
		url: base_url + "C_data_pengeluaran/get_data_pengeluaran_by_id",
		method: "POST",
		data: {
			id_pengeluaran: id_pengeluaran,
		},
		dataType: "JSON",
		success: function (data) {
			$("#id_pengeluaran").val(data[0].id_pengeluaran);
			$("#edit_tanggal_history_pengeluaran").val(data[0].tanggal);
			$("#edit_jenis_history_pengeluaran").val(data[0].jenis);
			$("#edit_jumlah_history_pengeluaran2").val(formatIDR(data[0].jumlah));
			$("#edit_keterangan_history_pengeluaran").val(data[0].keterangan);
			$("#foto_lama_history_pengeluaran").val(data[0].file_path);
			$("#current_image_history_pengeluaran").attr("src", data[0].file_path);
		},
	});
	$("#modal_edit_history_data_pengeluaran").modal("show");
}

// Edit Data : v_budget_pengeluaran
function openEditBudgetPengeluaran(id_budget) {
	$.ajax({
		url: base_url + "C_data_pengeluaran/get_data_budget_by_id",
		method: "POST",
		data: {
			id_budget: id_budget,
		},
		dataType: "JSON",
		success: function (data) {
			$("#id_budget").val(data[0].id_budget);
			$("#edit_bulan").val(data[0].bulan);
			$("#edit_tahun").val(data[0].tahun);
			$("#edit_keterangan").val(data[0].keterangan);
			$("#edit_jumlah_budget2").val(formatIDR(data[0].jumlah));
			$("#edit_status").val(data[0].status);
		},
	});
	$("#modal_edit_budget_pengeluaran").modal("show");
}

// Edit Data : v_data_tagihan
function openEditDataTagihan(id_tagihan) {
	$.ajax({
		url: base_url + "C_data_tagihan/get_data_tagihan_by_id",
		method: "POST",
		data: {
			id_tagihan: id_tagihan,
		},
		dataType: "JSON",
		success: function (data) {
			$("#id_tagihan").val(data[0].id_tagihan);
			$("#edit_nama_merchant").val(data[0].nama_merchant);
			$("#edit_jumlah_tenor").val(data[0].jml_tenor);
			$("#edit_jumlah_bayar").val(formatIDR(data[0].jml_bayar));
			$("#edit_sudah_dibayar").val(data[0].sudah_dibayar);
			$("#edit_belum_dibayar").val(data[0].belum_dibayar);
			$("#edit_jatuh_tempo").val(data[0].tgl_jatuh_tempo);
			$("#edit_keterangan").val(data[0].keterangan);
			$("#edit_status").val(data[0].status);
		},
	});
	$("#modal_edit_data_tagihan").modal("show");
}

// Edit Data : v_data_thr
function openEditDataThr(id_thr) {
	$.ajax({
		url: base_url + "C_data_thr/get_data_thr_by_id",
		method: "POST",
		data: {
			id_thr: id_thr,
		},
		dataType: "JSON",
		success: function (data) {
			$("#id_thr").val(data[0].id_thr);
			$("#edit_penerima").val(data[0].penerima);
			$("#edit_nominal").val(formatIDR(data[0].nominal));
			$("#edit_keterangan").val(data[0].keterangan);
			$("#edit_status").val(data[0].status);
		},
	});
	$("#modal_edit_data_thr").modal("show");
}

// Tampil Data : v_history_data_pemasukan
function openBuktiHistoryDataPemasukan(id_pemasukan) {
	$.ajax({
		url: base_url + "C_data_pemasukan/get_data_pemasukan_by_id",
		method: "POST",
		data: {
			id_pemasukan: id_pemasukan,
		},
		dataType: "JSON",
		success: function (data) {
			console.log(data);
			$("#detail_bukti").attr("src", data[0].file_path);
		},
	});
	$("#modal_bukti_history_data_pemasukan").modal("show");
}

// Tampil Data : v_history_data_pengeluaran
function openBuktiHistoryDataPengeluaran(id_pengeluaran) {
	$.ajax({
		url: base_url + "C_data_pengeluaran/get_data_pengeluaran_by_id",
		method: "POST",
		data: {
			id_pengeluaran: id_pengeluaran,
		},
		dataType: "JSON",
		success: function (data) {
			$("#detail_bukti_pengeluaran").attr("src", data[0].file_path);
		},
	});
	$("#modal_bukti_history_data_pengeluaran").modal("show");
}

// Hapus Data : v_history_data_pemasukan
function confirmDeletePemasukan(id_pemasukan) {
	Swal.fire({
		title: "Hapus data?",
		text: "Data tidak dapat di kembalikan!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Hapus",
		cancelButtonText: "Batal",
	}).then((result) => {
		if (result.isConfirmed) {
			window.location.href =
				base_url + "C_data_pemasukan/delete_data_pemasukan/" + id_pemasukan;
		}
	});
}

// Hapus Data : v_history_data_pengeluaran
function confirmDeletePengeluaran(id_pengeluaran) {
	Swal.fire({
		title: "Hapus data?",
		text: "Data tidak dapat di kembalikan!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Hapus",
		cancelButtonText: "Batal",
	}).then((result) => {
		if (result.isConfirmed) {
			window.location.href =
				base_url +
				"C_data_pengeluaran/delete_data_pengeluaran/" +
				id_pengeluaran;
		}
	});
}

// Hapus Data : v_budget_pengeluaran
function confirmDeleteBudget(id_budget) {
	Swal.fire({
		title: "Hapus data?",
		text: "Data tidak dapat di kembalikan!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Hapus",
		cancelButtonText: "Batal",
	}).then((result) => {
		if (result.isConfirmed) {
			window.location.href =
				base_url +
				"C_data_pengeluaran/delete_data_budget_pengeluaran/" +
				id_budget;
		}
	});
}

// Hapus Data : v_budget_pengeluaran
function confirmDeletePlanning(id_budget) {
	Swal.fire({
		title: "Hapus data?",
		text: "Data tidak dapat di kembalikan!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Hapus",
		cancelButtonText: "Batal",
	}).then((result) => {
		if (result.isConfirmed) {
			window.location.href =
				base_url + "C_data_planning/delete_data_planning/" + id_budget;
		}
	});
}

// Hapus Data : v_data_tagihan
function confirmDeleteTagihan(id_tagihan) {
	Swal.fire({
		title: "Hapus data?",
		text: "Data tidak dapat di kembalikan!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Hapus",
		cancelButtonText: "Batal",
	}).then((result) => {
		if (result.isConfirmed) {
			window.location.href =
				base_url + "C_data_tagihan/delete_data_tagihan/" + id_tagihan;
		}
	});
}

// Hapus Data : v_data_thr
function confirmDeleteThr(id_thr) {
	Swal.fire({
		title: "Hapus data?",
		text: "Data tidak dapat di kembalikan!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Hapus",
		cancelButtonText: "Batal",
	}).then((result) => {
		if (result.isConfirmed) {
			window.location.href = base_url + "C_data_thr/delete_data_thr/" + id_thr;
		}
	});
}

function formatRupiah(angka) {
	var number_string = angka.replace(/[^,\d]/g, "").toString();
	var split = number_string.split(",");
	var sisa = split[0].length % 3;
	var rupiah = split[0].substr(0, sisa);
	var ribuan = split[0].substr(sisa).match(/\d{3}/gi);

	if (ribuan) {
		var separator = sisa ? "." : "";
		rupiah += separator + ribuan.join(".");
	}

	rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
	return "Rp. " + rupiah;
}

function formatIDR(number) {
	var options = {
		style: "currency",
		currency: "IDR",
	};

	var formattedNumber;

	if (number % 1 === 0) {
		options.minimumFractionDigits = 0;
		options.maximumFractionDigits = 0;
		formattedNumber =
			new Intl.NumberFormat("id-ID", options).format(number) + ",-";
	} else {
		options.minimumFractionDigits = 2;
		options.maximumFractionDigits = 2;
		formattedNumber = new Intl.NumberFormat("id-ID", options).format(number);
	}

	return formattedNumber.replace("Rp", "Rp.");
}

function ubahFormatTanggal(tanggal) {
	var date = new Date(tanggal);
	var bulan = [
		"Januari",
		"Februari",
		"Maret",
		"April",
		"Mei",
		"Juni",
		"Juli",
		"Agustus",
		"September",
		"Oktober",
		"November",
		"Desember",
	];
	var hari = String(date.getDate()).padStart(2, "0");
	var bulanNama = bulan[date.getMonth()];
	var tahun = date.getFullYear();

	return hari + " " + bulanNama + " " + tahun;
}

// Detail Planning : Menghitung Jumlah Total Estimasi Planing (v_planning.php)
function calculateTotal() {
	let total = 0;
	$(".estimasi_harga").each(function () {
		let value = $(this).val();
		// Remove 'Rp' and commas
		value = value.replace(/Rp|\./g, "").trim();
		// Convert to integer
		let intValue = parseInt(value);
		if (!isNaN(intValue)) {
			total += intValue;
		}
	});
	$("#total_harga_planning").val("Rp. " + total.toLocaleString("id-ID"));
}

// Delete Detail Planning : v_planning.php
$("#detail_container").on("click", ".btn_delete_detail", function () {
	$(this).closest(".detail-row").remove();
	calculateTotal();
});

$(document).on("input", ".estimasi_harga", function () {
	var value = $(this).val();
	var formattedValue = formatRupiah(value);
	$(this).val(formattedValue);
});

// v_dashboard
function confirmTruncate() {
	Swal.fire({
		title: "Yakin?",
		text: "Semua data akan terhapus!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Lanjutkan",
		cancelButtonText: "Batal",
	}).then((result) => {
		if (result.isConfirmed) {
			window.location.href = base_url + "C_truncate_data/truncate_tables";
		}
	});
}
