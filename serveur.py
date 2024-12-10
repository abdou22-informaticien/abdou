import socket

host = '127.0.0.1'
port = int(input("Entrez le numéro de port à écouter : "))

server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
server_socket.bind((host, port))
server_socket.listen(5)
print("Serveur en écoute sur le port", port)

while True: 
    sock_client, addr_client = server_socket.accept()
    print("Connexion acceptée depuis", addr_client)
    data = sock_client.recv(1024).decode()
    print("Message reçu:", data)
    sock_client.send("Message bien reçu.".encode())
    sock_client.close()