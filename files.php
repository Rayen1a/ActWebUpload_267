<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud Vault — Storage Explorer</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        :root {
            --bg-gradient: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #311042 100%);
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.08);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --accent: #6366f1;
            --danger: #ef4444;
            --danger-bg: rgba(239, 68, 68, 0.1);
            --success: #10b981;
            --success-bg: rgba(16, 185, 129, 0.1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-gradient);
            color: var(--text-primary);
            margin: 0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            box-sizing: border-box;
        }

        .card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            padding: 40px;
            border-radius: 24px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            margin: 0 0 24px 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.03em;
            text-align: center;
            background: linear-gradient(to right, #ffffff, #cbd5e1);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .asset-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 24px;
        }

        .asset-item {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--glass-border);
            padding: 14px 20px;
            border-radius: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .asset-item:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.15);
            transform: translateX(4px);
        }

        .asset-info {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .asset-bullet {
            width: 8px;
            height: 8px;
            background: var(--accent);
            border-radius: 50%;
            flex-shrink: 0;
            box-shadow: 0 0 8px var(--accent);
        }

        .asset-name {
            font-size: 14px;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .action-group {
            display: flex;
            gap: 8px;
            flex-shrink: 0;
        }

        .btn {
            font-family: inherit;
            padding: 8px 14px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-download {
            background: var(--success-bg);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .btn-download:hover {
            background: var(--success);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .btn-delete {
            background: var(--danger-bg);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .btn-delete:hover {
            background: var(--danger);
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-secondary);
            font-size: 14px;
            border: 1px dashed rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.01);
        }

        .nav-footer {
            text-align: center;
            border-top: 1px solid var(--glass-border);
            padding-top: 24px;
        }

        .link {
            font-size: 13px;
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.2s;
            font-weight: 500;
        }

        .link:hover {
            color: var(--accent);
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Eksplorasi Dokumen Terunggah</h2>
    
    <div class="asset-list">
        <?php
        $dir = "uploads/";
        if (is_dir($dir)) {
            $files = array_diff(scandir($dir), array('.', '..'));
            
            if (count($files) > 0) {
                foreach ($files as $file) {
                    echo "<div class='asset-item'>";
                    echo "  <div class='asset-info'>";
                    echo "      <div class='asset-bullet'></div>";
                    echo "      <div class='asset-name' title='" . htmlspecialchars($file) . "'>" . htmlspecialchars($file) . "</div>";
                    echo "  </div>";
                    echo "  <div class='action-group'>";
                    echo "      <a href='" . $dir . rawurlencode($file) . "' download class='btn btn-download'>Unduh</a>";
                    echo "      <a href='delete.php?name=" . urlencode($file) . "' onclick='return confirm(\"Hapus aset dari cloud vault?\")' class='btn btn-delete'>Hapus</a>";
                    echo "  </div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='empty-state'>📭 Belum ada berkas data yang tersimpan di dalam repositori.</div>";
            }
        } else {
            echo "<div class='empty-state'>Direktori penyimpanan data belum dikonfigurasi.</div>";
        }
        ?>
    </div>
    
    <div class="nav-footer">
        <a href="index.html" class="link">← Kembali ke Panel Unggah Berkas</a>
    </div>
</div>

</body>
</html>