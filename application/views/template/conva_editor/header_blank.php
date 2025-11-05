<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>OKRE Sketch — Canvas Blank</title>

<!-- Font Awesome (includes fa-aws brand icon) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root{
  --blue-500:#1976d2; --blue-600:#1565c0; --bg:#f8f9fb; --card:#ffffff; --muted:#6b7280; --glass: rgba(255,255,255,0.9); --shadow: 0 8px 30px rgba(12,34,80,0.06);
}
html,body{height:100%;margin:0;font-family: "Segoe UI", Roboto, Arial, sans-serif;background:var(--bg);color:#0b2540}
.app{display:flex;height:100vh;overflow:visible}
#leftbar{ width:88px; background: linear-gradient(180deg,var(--card),#f0f7ff); border-right:1px solid rgba(25,118,210,0.06); display:flex;flex-direction:column;align-items:center;padding:12px 8px;gap:12px; position:fixed; top:0; left:0; bottom:0; height:100vh; z-index:1000; box-shadow:var(--shadow) }
.left-icon{ width:52px;height:52px;border-radius:12px;display:flex;align-items:center;justify-content:center;background:transparent;border:1px solid transparent;color:var(--blue-600);cursor:pointer;transition:all .18s;font-size:20px }
.left-icon:hover{transform:translateY(-3px);box-shadow:0 6px 14px rgba(25,118,210,0.06);background:linear-gradient(180deg,#fff,#f0f7ff)}
.left-icon.active{background:linear-gradient(180deg,var(--blue-500),var(--blue-600)); color:white; box-shadow:0 10px 20px rgba(25,118,210,0.14)}
#previewPanel{flex:1;width:100%;overflow-y:auto;display:flex;flex-direction:column;gap:10px;padding:8px 0;align-items:center;box-sizing:border-box}
.thumb{ width:64px;border-radius:8px;overflow:hidden;background:var(--card);border:2px solid transparent;box-shadow:0 6px 16px rgba(2,6,23,0.06);cursor:pointer;display:flex;justify-content:center;align-items:center;position:relative }
.thumb.active{ border-color: rgba(25,118,210,0.9); transform:translateY(-3px) }
.page-num{ position:absolute;font-size:11px;padding:4px 6px;border-radius:12px;background:rgba(255,255,255,0.9);left:6px;top:6px;color:#0b2540 }
.sidebar-footer{ position:sticky; bottom:0;background: linear-gradient(180deg,var(--card),#f0f7ff); width:100%;display:flex;align-items:center;justify-content:center;padding:8px 0;border-top:1px solid rgba(25,118,210,0.1) }
#main-area{ flex:1; display:flex; flex-direction:column; position:relative; margin-left:88px; margin-top:56px; padding-bottom:100px; height:calc(100vh - 56px); overflow:visible }
#topbar{ height:56px; display:flex; align-items:center; justify-content:space-between; padding:0 18px; border-bottom:1px solid rgba(25,118,210,0.06); background:linear-gradient(180deg, rgba(255,255,255,0.85), rgba(255,255,255,0.8)); position:fixed; top:0; left:88px; right:0; z-index:950 }
#topbar h2{margin:0;font-size:16px;color:var(--blue-600);letter-spacing:1px;display:flex;gap:8px;align-items:center}
.top-btn{background:var(--card);border:1px solid rgba(15,23,42,0.05);padding:8px 12px;border-radius:8px;cursor:pointer;display:flex;gap:8px;align-items:center}
html, body {
  height: 100%;
  margin: 0;
  overflow: hidden;
}

#main-area {
  flex: 1;
  display: flex;
  overflow: hidden;
  height: calc(100vh - 56px);
}

.container {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start;
  overflow-y: auto;
  padding: 20px 0;
  width: 100%;
  background: #fafafa;
}

.page {
  background: white;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  margin: 20px auto;
  position: relative;
  transform-origin: top center;
  transition: transform 0.2s ease;
}

.page.active {
  border: 2px solid var(--blue-600);
}

.page canvas { display:block }
.bottom-toolbar{ position:fixed; left:50%; transform:translateX(-50%); bottom:18px; height:64px; background: linear-gradient(180deg, rgba(255,255,255,0.95), rgba(245,253,255,0.95)); border-radius:999px; padding:6px 14px; display:flex; gap:10px; align-items:center; z-index:1100; box-shadow: 0 10px 30px rgba(10,25,60,0.12); border:1px solid rgba(25,118,210,0.08) }
.tool-btn{ width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:linear-gradient(180deg,#fff,#f7fbff);border:1px solid rgba(15,23,42,0.04);cursor:pointer; position:relative; transition: transform .14s }
.tool-btn:hover{ transform:translateY(-4px) }
.tool-btn.active{ background:linear-gradient(180deg,var(--blue-500),var(--blue-600)); color:white; border:0; box-shadow:0 10px 20px rgba(25,118,210,0.18) }
.tool-label{ position:absolute; bottom:120px; left:50%; transform:translateX(-50%); font-size:12px; background:rgba(2,6,23,0.9); color:white; padding:6px 8px;border-radius:6px; display:none }
.tool-btn:hover .tool-label{ display:block }
.popup{ position:absolute; bottom:72px; left:50%; transform:translateX(-50%) translateY(8px); min-width:220px; background:var(--card); border-radius:12px; padding:10px; box-shadow:0 12px 30px rgba(2,6,23,0.12); border:1px solid rgba(15,23,42,0.06); display:none; z-index:1100 }
.popup.show{ display:block; transform:translateX(-50%) translateY(0) }
.popup .row{ display:flex; gap:8px; align-items:center; margin-bottom:8px }
.small-btn{ padding:6px 10px;border-radius:8px;background:#f6fbff;border:1px solid rgba(10,20,40,0.04);cursor:pointer }
.small-btn:hover{ background:#eaf6ff }
@media (max-width:880px){ #leftbar{ display:none } .bottom-toolbar{ left:16px; transform:none; right:16px; justify-content:space-between } .popup{ left:auto; right:0; transform:translateY(8px); bottom:78px } }
</style>
</head>
<body>
<div class="app" id="appRoot">