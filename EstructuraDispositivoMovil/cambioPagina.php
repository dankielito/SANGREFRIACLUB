<div class="paginacion-footer">
    <div class="paginacion-circulos">
        <button class="page-btn active" onclick="changePage(1)">1</button>
        <button class="page-btn" onclick="changePage(2)">2</button>
        <button class="page-btn" onclick="changePage(3)">3</button>
    </div>
</div>

<style>
.paginacion-footer {
    margin-top: auto; /* Empuja hacia abajo */
    padding: 20px 0 10px 0;
    display: flex;
    justify-content: center;
    width: 100%;
    position: relative;
    z-index: 20;
}

.paginacion-circulos {
    display: flex;
    gap: 15px;
    background: rgba(120, 166, 181, 0.15);
    padding: 8px 15px;
    border-radius: 50px;
    border: 1px solid rgba(120, 166, 181, 0.3);
    backdrop-filter: blur(5px);
}

.page-btn {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    border: 2px solid transparent;
    background: white;
    color: #78a6b5;
    font-weight: 800;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.page-btn.active {
    background: #78a6b5;
    color: white;
    transform: scale(1.25);
    box-shadow: 0 0 15px rgba(120, 166, 181, 0.6);
    border-color: white;
}

.page-btn:active {
    transform: scale(0.9);
}
</style>