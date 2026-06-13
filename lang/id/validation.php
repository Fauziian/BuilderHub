<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Bahasa Indonesia untuk baris bahasa default yang digunakan oleh kelas validator.
    |
    */

    'accepted' => 'Kolom :attribute harus diterima.',
    'accepted_if' => 'Kolom :attribute harus diterima ketika :other berisi :value.',
    'active_url' => 'Kolom :attribute bukan URL yang valid.',
    'after' => 'Kolom :attribute harus berupa tanggal setelah :date.',
    'after_or_equal' => 'Kolom :attribute harus berupa tanggal setelah atau sama dengan :date.',
    'alpha' => 'Kolom :attribute hanya boleh berisi huruf.',
    'alpha_dash' => 'Kolom :attribute hanya boleh berisi huruf, angka, strip, dan garis bawah.',
    'alpha_num' => 'Kolom :attribute hanya boleh berisi huruf dan angka.',
    'array' => 'Kolom :attribute harus berupa sebuah array.',
    'ascii' => 'Kolom :attribute hanya boleh berisi karakter alfanumerik satu bita dan simbol.',
    'before' => 'Kolom :attribute harus berupa tanggal sebelum :date.',
    'before_or_equal' => 'Kolom :attribute harus berupa tanggal sebelum atau sama dengan :date.',
    'between' => [
        'array' => 'Kolom :attribute harus memiliki antara :min dan :max anggota.',
        'file' => 'Kolom :attribute harus berukuran antara :min dan :max kilobita.',
        'numeric' => 'Kolom :attribute harus bernilai antara :min dan :max.',
        'string' => 'Kolom :attribute harus berisi antara :min dan :max karakter.',
    ],
    'boolean' => 'Kolom :attribute harus bernilai true atau false.',
    'can' => 'Kolom :attribute berisi nilai yang tidak sah.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'contains' => 'Kolom :attribute kekurangan nilai yang diperlukan.',
    'current_password' => 'Kata sandi salah.',
    'date' => 'Kolom :attribute bukan tanggal yang valid.',
    'date_equals' => 'Kolom :attribute harus berupa tanggal yang sama dengan :date.',
    'date_format' => 'Kolom :attribute harus cocok dengan format :format.',
    'decimal' => 'Kolom :attribute harus memiliki :decimal tempat desimal.',
    'declined' => 'Kolom :attribute harus ditolak.',
    'declined_if' => 'Kolom :attribute harus ditolak ketika :other berisi :value.',
    'different' => 'Kolom :attribute dan :other harus berbeda.',
    'digits' => 'Kolom :attribute harus terdiri dari :digits angka.',
    'digits_between' => 'Kolom :attribute harus terdiri dari antara :min dan :max angka.',
    'dimensions' => 'Kolom :attribute memiliki dimensi gambar yang tidak valid.',
    'distinct' => 'Kolom :attribute memiliki nilai ganda.',
    'doesnt_contain' => 'Kolom :attribute tidak boleh berisi nilai berikut: :values.',
    'doesnt_end_with' => 'Kolom :attribute tidak boleh diakhiri dengan salah satu dari berikut: :values.',
    'doesnt_start_with' => 'Kolom :attribute tidak boleh diawali dengan salah satu dari berikut: :values.',
    'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
    'ends_with' => 'Kolom :attribute harus diakhiri dengan salah satu dari berikut: :values.',
    'enum' => 'Pilihan :attribute tidak valid.',
    'exists' => 'Pilihan :attribute tidak valid.',
    'extensions' => 'Kolom :attribute harus memiliki salah satu ekstensi berikut: :values.',
    'file' => 'Kolom :attribute harus berupa berkas.',
    'filled' => 'Kolom :attribute harus memiliki nilai.',
    'gt' => [
        'array' => 'Kolom :attribute harus memiliki lebih dari :value anggota.',
        'file' => 'Kolom :attribute harus berukuran lebih besar dari :value kilobita.',
        'numeric' => 'Kolom :attribute harus bernilai lebih besar dari :value.',
        'string' => 'Kolom :attribute harus berisi lebih dari :value karakter.',
    ],
    'gte' => [
        'array' => 'Kolom :attribute harus memiliki :value anggota atau lebih.',
        'file' => 'Kolom :attribute harus berukuran lebih besar dari atau sama dengan :value kilobita.',
        'numeric' => 'Kolom :attribute harus bernilai lebih besar dari atau sama dengan :value.',
        'string' => 'Kolom :attribute harus berisi lebih dari atau sama dengan :value karakter.',
    ],
    'hex_color' => 'Kolom :attribute harus berupa warna heksadesimal yang valid.',
    'image' => 'Kolom :attribute harus berupa gambar.',
    'in' => 'Pilihan :attribute tidak valid.',
    'in_array' => 'Kolom :attribute tidak ada di :other.',
    'integer' => 'Kolom :attribute harus berupa bilangan bulat.',
    'ip' => 'Kolom :attribute harus berupa alamat IP yang valid.',
    'ipv4' => 'Kolom :attribute harus berupa alamat IPv4 yang valid.',
    'ipv6' => 'Kolom :attribute harus berupa alamat IPv6 yang valid.',
    'json' => 'Kolom :attribute harus berupa string JSON yang valid.',
    'lowercase' => 'Kolom :attribute harus berupa huruf kecil.',
    'lt' => [
        'array' => 'Kolom :attribute harus memiliki kurang dari :value anggota.',
        'file' => 'Kolom :attribute harus berukuran kurang dari :value kilobita.',
        'numeric' => 'Kolom :attribute harus bernilai kurang dari :value.',
        'string' => 'Kolom :attribute harus berisi kurang dari :value karakter.',
    ],
    'lte' => [
        'array' => 'Kolom :attribute tidak boleh memiliki lebih dari :value anggota.',
        'file' => 'Kolom :attribute harus berukuran kurang dari atau sama dengan :value kilobita.',
        'numeric' => 'Kolom :attribute harus bernilai kurang dari atau sama dengan :value.',
        'string' => 'Kolom :attribute harus berisi kurang dari atau sama dengan :value karakter.',
    ],
    'mac_address' => 'Kolom :attribute harus berupa alamat MAC yang valid.',
    'max' => [
        'array' => 'Kolom :attribute tidak boleh memiliki lebih dari :max anggota.',
        'file' => 'Kolom :attribute tidak boleh berukuran lebih besar dari :max kilobita.',
        'numeric' => 'Kolom :attribute tidak boleh bernilai lebih besar dari :max.',
        'string' => 'Kolom :attribute tidak boleh berisi lebih dari :max karakter.',
    ],
    'max_digits' => 'Kolom :attribute tidak boleh memiliki lebih dari :max digit.',
    'mimes' => 'Kolom :attribute harus berupa berkas berjenis: :values.',
    'mimetypes' => 'Kolom :attribute harus berupa berkas berjenis: :values.',
    'min' => [
        'array' => 'Kolom :attribute minimal harus memiliki :min anggota.',
        'file' => 'Kolom :attribute minimal harus berukuran :min kilobita.',
        'numeric' => 'Kolom :attribute minimal bernilai :min.',
        'string' => 'Kolom :attribute minimal berisi :min karakter.',
    ],
    'min_digits' => 'Kolom :attribute minimal harus memiliki :min digit.',
    'missing' => 'Kolom :attribute harus hilang.',
    'missing_if' => 'Kolom :attribute harus hilang saat :other adalah :value.',
    'missing_unless' => 'Kolom :attribute harus hilang kecuali :other adalah :value.',
    'missing_with' => 'Kolom :attribute harus hilang saat :values ada.',
    'missing_with_all' => 'Kolom :attribute harus hilang saat :values ada.',
    'multiple_of' => 'Kolom :attribute harus kelipatan dari :value.',
    'not_in' => 'Pilihan :attribute tidak valid.',
    'not_regex' => 'Format kolom :attribute tidak valid.',
    'numeric' => 'Kolom :attribute harus berupa angka.',
    'password' => [
        'letters' => 'Kolom :attribute harus mengandung setidaknya satu huruf.',
        'mixed' => 'Kolom :attribute harus mengandung setidaknya satu huruf besar dan satu huruf kecil.',
        'numbers' => 'Kolom :attribute harus mengandung setidaknya satu angka.',
        'symbols' => 'Kolom :attribute harus mengandung setidaknya satu simbol.',
        'uncompromised' => 'Kombinasi :attribute yang dimasukkan telah bocor dalam pelanggaran data. Silakan pilih :attribute yang lain.',
    ],
    'present' => 'Kolom :attribute wajib ada.',
    'present_if' => 'Kolom :attribute wajib ada bila :other adalah :value.',
    'present_unless' => 'Kolom :attribute wajib ada kecuali :other adalah :value.',
    'present_with' => 'Kolom :attribute wajib ada bila :values ada.',
    'present_with_all' => 'Kolom :attribute wajib ada bila :values ada.',
    'prohibited' => 'Kolom :attribute dilarang.',
    'prohibited_if' => 'Kolom :attribute dilarang jika :other adalah :value.',
    'prohibited_if_accepted' => 'Kolom :attribute dilarang jika :other disetujui.',
    'prohibited_if_declined' => 'Kolom :attribute dilarang jika :other ditolak.',
    'prohibited_unless' => 'Kolom :attribute dilarang kecuali :other ada di :values.',
    'prohibits' => 'Kolom :attribute melarang :other untuk ada.',
    'regex' => 'Format kolom :attribute tidak valid.',
    'required' => 'Kolom :attribute wajib diisi.',
    'required_array_keys' => 'Kolom :attribute harus berisi entri untuk: :values.',
    'required_if' => 'Kolom :attribute wajib diisi bila :other adalah :value.',
    'required_if_accepted' => 'Kolom :attribute wajib diisi bila :other disetujui.',
    'required_if_declined' => 'Kolom :attribute wajib diisi bila :other ditolak.',
    'required_unless' => 'Kolom :attribute wajib diisi kecuali :other ada di :values.',
    'required_with' => 'Kolom :attribute wajib diisi bila :values ada.',
    'required_with_all' => 'Kolom :attribute wajib diisi bila :values ada.',
    'required_without' => 'Kolom :attribute wajib diisi bila :values tidak ada.',
    'required_without_all' => 'Kolom :attribute wajib diisi bila tidak ada satupun :values yang ada.',
    'same' => 'Kolom :attribute dan :other harus sama.',
    'size' => [
        'array' => 'Kolom :attribute harus mengandung :size anggota.',
        'file' => 'Kolom :attribute harus berukuran :size kilobita.',
        'numeric' => 'Kolom :attribute harus berukuran :size.',
        'string' => 'Kolom :attribute harus berisi :size karakter.',
    ],
    'starts_with' => 'Kolom :attribute harus diawali dengan salah satu dari berikut: :values.',
    'string' => 'Kolom :attribute harus berupa string.',
    'timezone' => 'Kolom :attribute harus berupa zona waktu yang valid.',
    'unique' => 'Kolom :attribute sudah digunakan.',
    'uploaded' => 'Kolom :attribute gagal diunggah.',
    'uppercase' => 'Kolom :attribute harus berupa huruf besar.',
    'url' => 'Format kolom :attribute tidak valid.',
    'ulid' => 'Kolom :attribute harus berupa ULID yang valid.',
    'uuid' => 'Kolom :attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    */

    'custom' => [],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'title' => 'Judul',
        'description' => 'Deskripsi',
        'price' => 'Harga',
        'level' => 'Level',
        'category' => 'Kategori',
        'duration' => 'Durasi',
        'videos' => 'Video Pembelajaran',
        'videos.*.title' => 'Judul Video',
        'videos.*.video_url' => 'Link YouTube',
        'videos.*.duration' => 'Durasi Video',
    ],

];
