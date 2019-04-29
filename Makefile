IMAGE_NAME=gcr.io/radical-sloth/brock-bus

.PHONY: build
build:
	@docker build -t $(IMAGE_NAME) .

.PHONY: run
run:
	@docker run -p 80:80 $(IMAGE_NAME)

.PHONY: push
push:
	@docker push $(IMAGE_NAME)

.PHONY: deploy
deploy:
	@kubectl apply -f kubernetes/deployment.yaml -f kubernetes/service.yaml
