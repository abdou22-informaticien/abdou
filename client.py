import socket

# Saisie dynamique du numéro de port et du message
host = '127.0.0.1'
port = int(input("Entrez le numéro de port du serveur : "))
message = input("Entrez le message à envoyer : ")

# Création du socket et connexion
s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s.connect((host, port))

# Envoi et réception des données
s.send(message.encode())
data = s.recv(1024)
print("Message reçu du serveur:", data.decode())

# Fermeture du socket
s.close()